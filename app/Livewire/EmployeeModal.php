<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Employee as MEmployee;
use App\Models\Service;
use App\Models\User;
use App\Rules\Text;
use Illuminate\Support\Facades\App;
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
    public $name, $email, $password, $active, $prevImg, $description, $available_services = [], $service_ids = [], $services = [];
    public $current_date, $initial_date, $attendance_date;
    public $photo;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete', 'see_attendances', 'employee_pdf'];

    public function rules()
    {
        return [
            'name' => ['required', 'min:4', 'max:80', new Text()],
            'description' => ['required', 'min:8', 'max:120', new Text()],
            'email' => ['required', 'email', Rule::unique('users')->where(function ($query) {
                return $query->where('email', $this->id);
            })->ignore($this->id)],
            'active' => ['boolean', Rule::excludeIf($this->id == null)],
            'password' => [
                'nullable',
                Rule::when(!empty($this->password), ['required', Password::min(4)->max(12)->numbers()->letters()])
            ],
            'photo'  => [
                'nullable',
                Rule::when(!is_string($this->photo), 'required|image|max:1024|mimes:jpg')
            ],
            'service_ids' => [
                'nullable',
                Rule::when($this->id > 0, 'required|exists:services,id')
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

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ])->assignRole('employee');

        $employee = $user->employee()
            ->create([
                'description' => $this->description,
                'photo' => $path
            ]);

        $employee->services()->sync($this->service_ids);

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
        $this->services = $record->services()->pluck('services.id')->toArray();
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

        $employee->services()->sync($this->service_ids);

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

    public function delete(MEmployee $record)
    {
        $disk = Storage::disk('public');
        if (!is_null($record->photo) && $disk->exists($record->photo)) {
            $disk->delete($record->photo);
        }

        $record->delete();
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
        $this->available_services = [];
        $this->service_ids = [];
        $this->services = [];
        $this->dispatch('refreshParent')->to(Employee::class);
    }

    public function employee_pdf($record)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.jpg')));
        $attendances = Attendance::where('employee_id', $record)
            ->get();
        return response()->streamDownload(function () use ($attendances, $image) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.employee', [
                'attendances' => $attendances,
                'image' => $image
            ]);
            echo $pdf->stream();
        }, "Asistencia de empleado.pdf");
    }

    public function render()
    {
        $this->available_services = Service::where('active', 1)->get();

        if (empty($this->current_date)) {
            $this->current_date = now()->format('Y-m-d');
        }

        return view('livewire.employee-modal');
    }
}
