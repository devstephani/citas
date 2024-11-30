<?php

namespace App\Livewire;

use App\Enum\Service\TypeEnum;
use App\Models\Binnacle;
use App\Models\Employee;
use App\Models\Service;
use App\Rules\Text;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class ServiceModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $id = null;
    public $name, $description, $active, $price, $type, $prevImg, $available_employees = [], $employee_ids = [], $employees = [];
    public $image;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function rules()
    {
        return [
            'name' => ['required', new Text(), 'min:4', 'max:80', Rule::unique('services')->where(function ($query) {
                return $query->where('name', $this->name);
            })->ignore($this->id)],
            'description' => ['required', 'min:10', 'max:150', new Text()],
            'active' => ['boolean', Rule::excludeIf($this->id == null)],
            'price' => 'required|min:0.1|max:1000|numeric',
            'type' => ['required', Rule::enum(TypeEnum::class)],
            'image'  => [
                'nullable',
                Rule::when(!is_string($this->image), 'required|image|max:1024|mimes:jpg')
            ],
            'employee_ids' => [
                'nullable',
                Rule::when($this->id > 0 && count($this->employee_ids), 'required|exists:employees,id')
            ]
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
            'image.required' => 'Debe añadir una imágen',
            'image.image' => 'Debe ser una imágen',
            'image.max' => 'Debe pesar máximo 1 MB',
            'image.mimes' => 'Debe tener formato JPG',
            'image.extensions' => 'Debe tener formato JPG',
        ];
    }

    public function save()
    {
        $this->validate();
        $path = $this->image->store('public/services');

        $service = Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'active' => 1,
            'price' => $this->price,
            'type' => TypeEnum::from($this->type),
            'image' => $path,
            'user_id' => auth()->user()->id
        ]);

        $service->employees()->sync($this->employee_ids);


        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'success',
            'message' => "Se registró el servicio {$service->name}"
        ]);

        $this->resetUI();
    }

    public function toggle()
    {
        $this->resetUI();
        $this->showModal = ! $this->showModal;
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
        $this->employees = $record->employees()->pluck('employees.id')->toArray();
        $this->employee_ids = $this->employees;
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
        ]);

        $service->employees()->sync($this->employee_ids);


        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'success',
            'message' => "Se actualizó el servicio {$service->name}"
        ]);

        $this->resetUI();
    }

    public function delete(Service $record)
    {
        Storage::disk('public')->delete($record->image);
        $record->delete();

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'warning',
            'message' => "Se eliminó el servicio {$record->name}"
        ]);
        $this->resetUI();
    }

    public function toggle_active(Service $service)
    {
        $service->update([
            'active' => ! $service->active
        ]);

        $message = $service->active ? 'activó' : 'desactivó';
        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'info',
            'message' => "Se {$message} el servicio {$service->name}"
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
        $this->image = '';
        $this->prevImg = '';
        $this->active = '';
        $this->available_employees = [];
        $this->showModal = false;
        $this->dispatch('refreshParent')->to(Services::class);
    }

    public function render()
    {
        $this->available_employees = Employee::with('user')
            ->whereHas('user', function ($query) {
                $query->where('active', 1);
            })
            ->get();

        return view('livewire.service-modal');
    }
}
