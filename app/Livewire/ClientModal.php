<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Binnacle;
use App\Models\User;
use App\Rules\Text;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ClientModal extends Component
{
    public $showModal = false;
    public $id = null;
    public $name, $email, $password, $active, $phone;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete', 'user_pdf'];

    public function rules()
    {
        return [
            'name' => ['required', 'min:4', 'max:80', new Text()],
            'phone' => ['required', 'numeric', 'digits:11', Rule::unique('users')->ignore($this->id)],
            'email' => ['required', 'email', Rule::unique('users')->where(function ($query) {
                return $query->where('email', $this->email);
            })->ignore($this->id)],
            'active' => [
                'nullable',
                Rule::when(!is_null($this->id), 'required|boolean')
            ],
            'password' => [
                'nullable',
                Rule::when(!empty($this->password), ['required', Password::min(4)->max(12)->numbers()->letters()])
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe indicar el nombre',
            'name.regex' => 'Solo se aceptan letras',
            'name.min' => 'Debe contener al menos :min caracteres',
            'name.max' => 'Debe contener máximo :max caracteres',
            'phone.required' => 'Debe indicar el teléfono',
            'phone.numeric' => 'Debe ser un número',
            'phone.digits' => 'Debe contener 11 dígitos',
            'phone.unique' => 'El número ya fue registrado',
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
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ])->assignRole('client');

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'success',
            'message' => "Se registró el cliente {$this->name}"
        ]);

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
        $this->phone = $record->phone;
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
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'active' => $this->active
        ]);

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'success',
            'message' => "Se actualizó el cliente {$user->name}"
        ]);

        $this->resetUI();
    }

    public function delete(User $record)
    {
        $record->delete();

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'warning',
            'message' => "Se eliminó el cliente {$record->name}"
        ]);
        $this->resetUI();
    }

    public function toggle_active(User $user)
    {
        $user->update([
            'active' => ! $user->active
        ]);

        $message = $user->active ? 'activó' : 'desactivó';
        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'info',
            'message' => "Se {$message} el cliente {$user->name}"
        ]);

        $this->dispatch('refreshParent')->to(Client::class);
    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->active = '';
        $this->id = '';
        $this->showModal = false;
        $this->dispatch('refreshParent')->to(Client::class);
    }

    public function user_pdf(User $record)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.jpg')));
        $data = Appointment::with(['service', 'package', 'user', 'payment'])
            ->where('user_id', $record->id)
            ->whereYear('picked_date', '=', now()->format('Y'))
            ->get();

        return response()->streamDownload(function () use ($data, $image, $record) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.users', [
                'data' => $data,
                'image' => $image,
                'client' => $record
            ]);
            echo $pdf->stream();
        }, "Reporte de servicios y paquetes de usuario {$record->name}.pdf");
    }

    public function render()
    {
        return view('livewire.client-modal');
    }
}
