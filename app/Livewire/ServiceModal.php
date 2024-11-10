<?php

namespace App\Livewire;

use App\Enum\Service\TypeEnum;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServiceModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $id = null;
    public $name, $description, $active, $price, $type, $prevImg, $employee_id;

    #[Validate('image|max:1024')]
    public $image;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function save()
    {
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
