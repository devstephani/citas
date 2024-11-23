<?php

namespace App\Livewire;

use App\Models\Employee as MEmployee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EmployeeModal extends Component
{
    use WithFileUploads;
    public $showModal = false, $show_attendance_modal = false;
    public $id = null, $employee_attendances, $employee;
    public $name, $email, $password, $active, $prevImg, $description;
    public $current_date, $initial_date, $attendance_date;
    public $photo;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete', 'see_attendances'];

    public function rules()
    {
        return [
            'name' => 'required|min:4|max:80|regex:/^[a-zA-Z0-9\s]+$/',
            'description' => 'required|min:8|max:120|regex:/^[a-zA-Z0-9\s]+$/',
            'email' => ['required', 'email', Rule::unique('users')->where(function ($query) {
                return $query->where('email', $this->email);
            })->ignore($this->id)],
            'active' => ['boolean', Rule::excludeIf($this->id == null)],
            'password' => ['required', Password::min(4)->max(12)->numbers()->letters()],
            'photo'  => [
                'nullable',
                Rule::when(!is_string($this->image), 'required|image|max:1024|mimes:jpg')
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
            'description.required' => 'Debe indicar la descripción',
            'description.regex' => 'Solo se aceptan letras',
            'description.min' => 'Debe contener al menos :min caracteres',
            'description.max' => 'Debe contener máximo :max caracteres',
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
            'photo.required' => 'Debe añadir una imágen',
            'photo.image' => 'Debe ser una imágen',
            'photo.max' => 'Debe pesar máximo 1 MB',
            'photo.mimes' => 'Debe tener formato JPG',
            'photo.extensions' => 'Debe tener formato JPG',
        ];
    }

    public function save()
    {
        $this->validate();
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
        $this->show_attendance_modal = false;
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
        $this->validate();
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

    public function updatedAttendanceDate()
    {
        $this->fetch_attendances();
    }

    public function fetch_attendances()
    {
        if ($this->employee) {
            $today = now()->format('Y-m-d');
            $date = $this->attendance_date ?? $today;

            $this->initial_date = $this->employee->attendances()
                ->orderBy('created_at')
                ->first();

            $this->initial_date = !empty($this->initial_date)
                ? $this->initial_date->created_at->format('Y-m-d')
                : $today;

            $this->employee_attendances = $this->employee->attendances()
                ->whereDate('created_at', $date)
                ->orderByDesc('created_at')
                ->get();

            $this->name = $this->employee->user->name;
        }
    }

    public function see_attendances(MEmployee $record)
    {
        $this->employee = $record;
        $this->fetch_attendances();
        $this->show_attendance_modal = true;
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
        if (empty($this->current_date)) {
            $this->current_date = now()->format('Y-m-d');
        }

        return view('livewire.employee-modal');
    }
}
