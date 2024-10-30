<?php

namespace App\Livewire;

use App\Models\package;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PackageModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $id = null;
    public $service_ids = [];
    public $name, $description, $active, $price, $prevImg;

    #[Validate('image|max:1024')]
    public $image;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function save()
    {
        $path = $this->image->store('public/packages');

        $package = package::create([
            'name' => $this->name,
            'description' => $this->description,
            'active' => 1,
            'price' => $this->price,
            'image' => $path,
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
            dd($this->service_ids);
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
