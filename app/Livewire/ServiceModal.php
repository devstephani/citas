<?php

namespace App\Livewire;

use App\Enum\Service\TypeEnum;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class ServiceModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $id = null;
    public $name, $description, $active, $price, $type, $prevImg, $employee_id;

    #[Validate('image|max:1024|mimetypes:image/jpg')]
    public $image;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function rules()
    {
        return [
            'name' => ['required', 'min:4', 'max:80', 'regex:/^[a-zA-Z\s]+$/', Rule::unique('services')->where(function ($query) {
                return $query->where('name', $this->name);
            })->ignore($this->id)],
            'description' => 'required|min:10|max:150|regex:/^[a-zA-Z\s]+$/',
            'active' => 'required|boolean',
            'price' => 'required|min:0.1|max:1000|numeric',
            'type' => ['required', 'in:' . TypeEnum::cases()]

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe indicar el nombre',
            'name.regex' => 'Solo se aceptan letras',
            'name.min' => 'Debe contener al menos :min caracteres',
            'name.max' => 'Debe contener máximo :max caracteres',
            'name.unique' => 'Este nombre se encuentra registrado',
            'description.required' => 'Debe indicar la descripción',
            'description.regex' => 'Solo se aceptan letras',
            'description.min' => 'Debe contener al menos :min caracteres',
            'description.max' => 'Debe contener máximo :max caracteres',
            'active.required' => 'Debe seleccionar alguna opción',
            'active.boolean' => 'La opción seleccionada debe ser "Si" o "No"',
            'price.required' => 'Debe indicar el precio',
            'price.min' => 'Debe ser al menos :min',
            'price.max' => 'Debe ser máximo :min',
            'price.numeric' => 'Debe ser un número',
            'type.required' => 'Debe seleccionar una opción',
            'type.in' => 'Debe seleccionar una opción de la lista',
        ];
    }

    public function save()
    {
        $this->validate();
        $path = $this->image->store('public/services');

        Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'active' => 1,
            'price' => $this->price,
            'type' => TypeEnum::from($this->type),
            'image' => $path,
            'employee_id' => $this->employee_id
        ]);

        $this->resetUI();
    }

    public function toggle()
    {
        $this->resetUI();
        $this->showModal = ! $this->showModal;
    }

    public function select_employee($id)
    {
        $this->employee_id = $id;
    }


    public function edit(service $record)
    {
        $this->showModal = true;
        $this->id = $record->id;
        $this->name = $record->name;
        $this->description = $record->description;
        $this->type = $record->type;
        $this->price = $record->price;
        $this->image = $record->image;
        $this->prevImg = $record->image;
        $this->active = $record->active;
        $this->employee_id = $record->employee_id;
    }

    public function update()
    {
        $this->validate();
        $service = Service::find($this->id);

        if ($this->image !== $this->prevImg) {
            Storage::disk('public')->delete($service->image);
            $path = $this->image->store('public/services');

            $service->update([
                'image' => $path,
            ]);
        }

        $service->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'type' => TypeEnum::from($this->type->value),
            'active' => $this->active,
            'employee_id' => $this->employee_id
        ]);

        $this->resetUI();
    }

    public function delete(Service $record)
    {
        Storage::disk('public')->delete($record->image);
        $record->delete();
        $this->resetUI();
    }

    public function toggle_active(Service $service)
    {
        $service->update([
            'active' => ! $service->active
        ]);

        $this->dispatch('refreshParent')->to(Services::class);
    }

    public function resetUI()
    {
        $this->showModal = true;
        $this->id = '';
        $this->name = '';
        $this->description = '';
        $this->type = '';
        $this->price = '';
        $this->employee_id = null;
        $this->image = '';
        $this->prevImg = '';
        $this->active = '';
        $this->showModal = false;
        $this->dispatch('refreshParent')->to(Services::class);
    }

    public function render()
    {
        $employees = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['employee']);
            })
            ->get();
        return view('livewire.service-modal', [
            'employees' => $employees
        ]);
    }
}
