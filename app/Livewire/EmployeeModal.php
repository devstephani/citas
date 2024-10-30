<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EmployeeModal extends Component
{
    public $showModal = false;
    public $id = null;
    public $name, $email, $password, $active;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function save()
    {
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ])->assignRole('employee');

        $this->resetUI();
    }

    public function toggle()
    {
        $this->resetUI();
        $this->showModal = ! $this->showModal;
    }


    public function edit(User $record)
    {
        $this->showModal = true;
        $this->id = $record->id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->active = $record->active;
    }

    public function update()
    {
        $user = User::find($this->id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'active' => $this->active
        ]);

        $this->resetUI();
    }

    public function delete(User $user)
    {
        $user->delete();
        $this->resetUI();
    }

    public function toggle_active(User $user)
    {
        $user->update([
            'active' => ! $user->active
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
        $this->dispatch('refreshParent')->to(Employee::class);
    }

    public function render()
    {
        return view('livewire.employee-modal');
    }
}
