<?php

namespace App\Livewire;

use App\Models\package;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class PackageModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $id = null;
    public $service_ids = [];
    public $name, $description, $active, $price, $prevImg;

    #[Validate('required|image|max:1024|mimes:jpg|extensions:jpg')]
    public $image;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function rules()
    {
        $services = Service::pluck('id')->toArray();
        return [
            'name' => ['required', 'min:4', 'max:80', 'regex:/^[a-zA-Z\s]+$/', Rule::unique('packages')->where(function ($query) {
                return $query->where('name', $this->name);
            })->ignore($this->id)],
            'description' => 'required|min:10|max:150|regex:/^[a-zA-Z\s]+$/',
            'active' => ['boolean', Rule::excludeIf($this->id == null)],
            'price' => 'required|min:0.1|max:1000|numeric',
            'service_ids' => ['required', Rule::in($services)]
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
            'email.required' => 'Debe indicar el correo',
            'email.email' => 'Debe ser un correo válido',
            'active.required' => 'Debe seleccionar alguna opción',
            'active.boolean' => 'La opción seleccionada debe ser "Si" o "No"',
            'price.required' => 'Debe indicar el precio',
            'price.min' => 'Debe ser al menos :min',
            'price.max' => 'Debe ser máximo :min',
            'price.numeric' => 'Debe ser un número',
            'image.required' => 'Debe añadir una imágen',
            'image.image' => 'Debe ser una imágen',
            'image.max' => 'Debe pesar máximo 1 MB',
            'image.mimes' => 'Debe tener formato JPG',
            'image.extensions' => 'Debe tener formato JPG',
            'service_ids.required' => 'Debe seleccionar al menos 1 opción',
            'service_ids.notIn' => 'Debe seleccionar una opción en la lista'
        ];
    }

    public function save()
    {
        $this->validate();
        $path = $this->image->store('public/packages');

        $package = package::create([
            'name' => $this->name,
            'description' => $this->description,
            'active' => 1,
            'price' => $this->price,
            'image' => $path,
            'user_id' => auth()->user()->id
        ]);

        $package->services()->sync($this->service_ids);

        $this->resetUI();
    }

    public function toggle()
    {
        $this->resetUI();
        $this->showModal = ! $this->showModal;
    }

    public function select_packages($id)
    {
        if (in_array($id, $this->service_ids)) {
            $this->service_ids = array_diff($this->service_ids, [$id]);
        } else {
            $this->service_ids[] = $id;
        }
    }


    public function edit(package $record)
    {
        $this->showModal = true;
        $this->id = $record->id;
        $this->name = $record->name;
        $this->description = $record->description;
        $this->price = $record->price;
        $this->image = $record->image;
        $this->prevImg = $record->image;
        $this->active = $record->active;
        $this->service_ids = $record->services->pluck('id')->toArray();
    }

    public function update()
    {
        $this->validate();
        $package = package::find($this->id);

        if ($this->image !== $this->prevImg) {
            Storage::disk('public')->delete($package->image);
            $path = $this->image->store('public/packages');

            $package->update([
                'image' => $path,
            ]);
        }

        $package->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'active' => $this->active,
        ]);

        $package->services()->sync($this->service_ids);

        $this->resetUI();
    }

    public function delete(package $record)
    {
        Storage::disk('public')->delete($record->image);
        $record->delete();
        $this->resetUI();
    }

    public function toggle_active(package $package)
    {
        $package->update([
            'active' => ! $package->active
        ]);

        $this->dispatch('refreshParent')->to(Packages::class);
    }

    public function resetUI()
    {
        $this->showModal = true;
        $this->id = '';
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->image = '';
        $this->prevImg = '';
        $this->active = '';
        $this->showModal = false;
        $this->service_ids = [];
        $this->dispatch('refreshParent')->to(Packages::class);
    }

    public function render()
    {
        $services = Service::all();

        return view('livewire.package-modal', [
            'services' => $services
        ]);
    }
}
