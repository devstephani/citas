<?php

namespace App\Livewire;

use App\Models\Employee as MEmployee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmployeeModal extends Component
{
    use WithFileUploads;
    public $showModal = false;
    public $id = null;
    public $name, $email, $password, $active, $prevImg, $description;

    #[Validate('image|max:1024')]
    public $photo;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function save()
    {
        $path = $this->photo->store('public/employees');

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ])->assignRole('employee')
            ->employee()
            ->create([
                'description' => $this->description,
                'photo' => $path
            ]);

        $this->resetUI();
    }

    public function toggle()
    {
        $this->resetUI();
        $this->showModal = ! $this->showModal;
    }

    public function edit(MEmployee $record)
    {
        $this->showModal = true;
        $this->id = $record->id;
        $this->name = $record->user->name;
        $this->email = $record->user->email;
        $this->active = $record->user->active;
        $this->description = $record->description;
        $this->photo = $record->photo;
        $this->prevImg = $record->photo;
    }

    public function update()
    {
        $employee = MEmployee::find($this->id);

        if ($this->photo !== $this->prevImg) {
            Storage::disk('public')->delete($employee->photo);
            $path = $this->photo->store('public/employees');

            $employee->update([
                'photo' => $path,
            ]);
        }

        $employee->update([
            'description' => $this->description,
        ]);
        $employee->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'active' => $this->active
        ]);

        if (!empty($this->password)) {
            $employee->user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $this->resetUI();
    }

    public function delete(MEmployee $employee)
    {
        Storage::disk('public')->delete($employee->photo);
        $employee->delete();
        $this->resetUI();
    }

    public function toggle_active(MEmployee $employee)
    {
        $employee->user()->update([
            'active' => ! $employee->user->active
        ]);

        $this->dispatch('refreshParent')->to(Employee::class);
    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->active = '';
        $this->id = '';
        $this->showModal = false;
        $this->photo = '';
        $this->description = '';
        $this->prevImg = '';
        $this->dispatch('refreshParent')->to(Employee::class);
    }

    public function render()
    {
        return view('livewire.employee-modal');
    }
}
