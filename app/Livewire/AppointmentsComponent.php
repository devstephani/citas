<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Package;
use App\Models\Service;
use App\Models\User;
use App\Rules\OneRequired;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AppointmentsComponent extends Component
{
    public $show_modal = false;
    public $id = 0, $client_name, $client_id = null, $clients, $services, $packages, $selected_service = 0, $selected_package = 0, $selected_date, $selected_time, $status;

    private $pagination = 20;
    protected $listeners = ['toggle', 'set_selected_day', 'edit', 'delete'];

    public $hours = [
        [
            'value' => '08:00:00',
            'text' => '08:00 a.m.'
        ],
        [
            'value' => '09:00:00',
            'text' => '09:00 a.m.'
        ],
        [
            'value' => '10:00:00',
            'text' => '10:00 a.m.'
        ],
        [
            'value' => '11:00:00',
            'text' => '11:00 a.m.'
        ],
        [
            'value' => '12:00:00',
            'text' => '12:00 p.m.'
        ],
        [
            'value' => '01:00:00',
            'text' => '01:00 p.m.'
        ],
        [
            'value' => '02:00:00',
            'text' => '02:00 p.m.'
        ],
        [
            'value' => '03:00:00',
            'text' => '03:00 p.m.'
        ],
        [
            'value' => '04:00:00',
            'text' => '04:00 p.m.'
        ],
        [
            'value' => '05:00:00',
            'text' => '05:00 p.m.'
        ],
        [
            'value' => '06:00:00',
            'text' => '06:00 p.m.'
        ],
    ];

    public function rules()
    {
        return [
            'selected_service' => ['nullable', new OneRequired('selected_package'), 'exists:services,id'],
            'selected_package' => ['nullable', new OneRequired('selected_service'), 'exists:packages,id'],
            'selected_time' => ['required', 'date_format:h:i:s'],
            'status' => [
                Rule::when(Auth::user()->hasRole('admin') && $this->id > 0, 'required|boolean')
            ],
            'client_id' => [
                'sometimes',
                Rule::when(Auth::user()->hasAnyRole('admin', 'emploee'), 'exists:users,id')
            ]
        ];
    }

    public function messages()
    {
        return [
            'selected_service.exists' => 'El servicio seleccionado no está registrado',
            'selected_package.exists' => 'El paquete seleccionado no está registrado',
            'selected_time.required' => 'Debe indicar la hora',
            'selected_time.date_format' => 'El formato de la hora es incorrecto',
            'client_id.exists' => 'El cliente seleccionado no está registrado',
            'status.required' => 'Debe seleccionar una opción',
            'status.boolean' => 'Debe selecionar una opción de la lista'
        ];
    }

    public function toggle()
    {
        $this->resetUI();
        $this->show_modal = ! $this->show_modal;
    }

    public function edit(Appointment $record)
    {
        $this->id = $record->id;
        $this->selected_service = $record->service_id;
        $this->selected_package = $record->package_id;
        $this->selected_time = explode(' ', $record->picked_date)[1];
        $this->client_id = $record->user_id;
        $this->show_modal = true;
        $this->client_name = $record->user->name;
        $this->status = $record->status;
    }

    public function update()
    {
        $this->validate();

        $record = Appointment::find($this->id);
        $date = explode(' ', $record->picked_date)[0];
        $record->update([
            'service' => $this->selected_service ?? null,
            'package' => $this->selected_package ?? null,
            'picked_date' => "$date $this->selected_time",
            'status' => $this->status
        ]);

        $this->dispatch(event: 'refreshParent')->to(AppointmentsCalendar::class);
        $this->resetUI();
    }

    public function updatedSelectedPackage()
    {
        $appointments = Appointment::where(function ($query) {
            $query->where('package_id', $this->selected_package)
                ->orWhereHas('service', function ($q) {
                    $q->whereHas('packages', function ($q) {
                        $q->where('packages.id', $this->selected_package);
                    });
                });
        })
            ->whereDate('picked_date', $this->selected_date)
            ->pluck('picked_date')
            ->toArray();

        $hours = array_map(function ($appointment) {
            return explode(' ', $appointment)[1];
        }, $appointments);

        $this->hours = array_filter($this->hours, function ($hour) use ($hours) {
            if (!in_array($hour['value'], $hours)) return $hour;
        });
    }

    public function updatedSelectedService()
    {
        $appointments = Appointment::where(function ($query) {
            $query->where('service_id', $this->selected_service)
                ->orWhereHas('package', function ($q) {
                    $q->whereHas('services', function ($q) {
                        $q->where('services.id', $this->selected_service);
                    });
                });
        })
            ->whereDate('picked_date', $this->selected_date)
            ->pluck('picked_date')
            ->toArray();

        $hours = array_map(function ($appointment) {
            return explode(' ', $appointment)[1];
        }, $appointments);

        $this->hours = array_filter($this->hours, function ($hour) use ($hours) {
            if (!in_array($hour['value'], $hours)) return $hour;
        });
    }

    public function set_selected_day($date)
    {
        $this->selected_date = $date;
    }

    public function save()
    {
        $final_date = "$this->selected_date $this->selected_time";

        $occupied = Appointment::where(function ($query) {
            $query->where('service_id', $this->selected_service)
                ->orWhere('package_id', $this->selected_package);
        })->where('picked_date', '=', $final_date)
            ->exists();

        if (!$occupied) {
            $this->validate();

            Appointment::create([
                'status' => 0,
                'user_id' => $this->client_id ?? Auth::user()->id,
                'service_id' => $this->selected_service ?? null,
                'package_id' => $this->selected_package ?? null,
                'picked_date' => $final_date
            ]);
            $this->resetUI();
            $this->dispatch(event: 'refreshParent')->to(AppointmentsCalendar::class);
        } else {
            $selected = $this->selected_service
                ? $this->services->find($this->selected_service)->first()->name
                : $this->packages->find($this->selected_package)->first()->name;

            $this->addError('selected_time', message: "La opción $selected ya se encuentra agendada para esta hora, indique otra hora");
        }
    }

    public function delete()
    {
        $record = Appointment::find($this->id);
        $record->delete();

        $this->show_modal = false;
        $this->dispatch(event: 'refreshParent')->to(AppointmentsCalendar::class);
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->selected_date = null;
        $this->selected_service = null;
        $this->selected_package = null;
        $this->selected_time = null;
        $this->show_modal = false;
        $this->id = 0;
        $this->client_id = null;
        $this->client_name = null;
        $this->status = 0;
    }
    public function mount()
    {
        $this->services = Service::where('active', 1)->get();
        $this->packages = Package::where('active', 1)->get();

        if (Auth::user()->hasAnyRole('admin', 'employee')) {
            $this->clients = User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })->get();
        }
    }

    #[Layout('layouts.app')]

    public function render()
    {
        $appointments = Appointment::orderByDesc('created_at')
            ->paginate($this->pagination);

        return view('livewire.appointments-component', [
            'appointments' => $appointments
        ]);
    }
}
