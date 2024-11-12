<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ClientModal extends Component
{
    public $showModal = false;
    public $id = null;
    public $name, $email, $password, $active;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function rules()
    {
        return [
            'name' => 'required|min:4|max:80|regex:/^[a-zA-Z\s]+$/',
            'email' => ['required', 'email', Rule::unique('users')->where(function ($query) {
                return $query->where('email', $this->email);
            })->ignore($this->id)],
            'active' => 'required|boolean',
            'password' => ['required', Password::min(4)->max(12)->numbers()->letters()],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe indicar el nombre',
            'name.regex' => 'Solo se aceptan letras',
            'name.min' => 'Debe contener al menos :min caracteres',
            'name.max' => 'Debe contener máximo :max caracteres',
            'email.required' => 'Debe indicar el correo',
            'email.email' => 'Debe ser un correo válido',
            'email.unique' => 'Este correo se encuentra registrado',
            'active.required' => 'Debe seleccionar alguna opción',
            'active.boolean' => 'La opción seleccionada debe ser "Si" o "No"',
            'password.required' => 'Debe indicar la contraseña',
            'password.min' => 'Debe ser al menos :min caracteres',
            'password.max' => 'Debe ser máximo :min caracteres',
            'password.numbers' => 'Debe ser contener al menos 1 número',
            'password.letters' => 'Debe ser contener al menos 1 letra',
        ];
    }

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ])->assignRole('client');

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
        $this->validate();

        $user = User::find($this->id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'active' => $this->active
        ]);

        $this->resetUI();
    }

    public function delete(User $record)
    {
        $record->delete();
        $this->resetUI();
    }

    public function toggle_active(User $user)
    {
        $user->update([
            'active' => ! $user->active
        ]);

        $this->dispatch('refreshParent')->to(Client::class);
    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->active = '';
        $this->id = '';
        $this->showModal = false;
        $this->dispatch('refreshParent')->to(Client::class);
    }

    public function render()
    {
        return view('livewire.client-modal');
    }
}
