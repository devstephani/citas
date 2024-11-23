<?php

namespace App\Livewire;

use App\Enum\Payment\CurrencyEnum;
use App\Enum\Payment\TypeEnum;
use App\Models\Appointment;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use App\Rules\OneRequired;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AppointmentsComponent extends Component
{
    public $show_modal = false, $discount = false;
    public $id = 0, $client_name, $client_id = null, $clients, $services, $packages, $selected_service = 0, $selected_package = 0, $selected_date, $selected_time, $status, $registered_local, $type, $currency, $payed, $ref, $frequent_appointments, $selected_frequent_appointment;

    private $pagination = 20;
    protected $listeners = ['toggle', 'set_selected_day', 'edit', 'delete', 'set_appointment'];

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
            ],
            'type' => [
                'sometimes',
                Rule::when($this->status === '1', [
                    'required',
                    Rule::in(array_column(TypeEnum::cases(), 'value'))
                ]),
                Rule::when($this->currency === 'Bs', [
                    'required',
                    Rule::notIn(array_filter(array_column(TypeEnum::cases(), 'value'), function ($value) {
                        return $value === 'PagoMóvil';
                    }))
                ]),
            ],
            'currency' => [
                'sometimes',
                Rule::when($this->status === '1', [
                    'required',
                    Rule::in(array_column(CurrencyEnum::cases(), 'value'))
                ]),
            ],
            'payed' => [
                'sometimes',
                Rule::when($this->status === '1', 'required|min:0.1|max:1000|numeric')
            ],
            'ref' => [
                'sometimes',
                Rule::when($this->type === 'PagoMóvil' || $this->type === 'Paypal', 'required|min:3|max:8|regex:/^[0-9]+$/')
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
            'status.boolean' => 'Debe selecionar una opción de la lista',
            'type.required' => 'Debe indicar el tipo de pago',
            'type.in' => 'Debe seleccionar una opción de la lista',
            'currency.required' => 'Debe indicar el tipo de moneda',
            'currency.in' => 'Debe seleccionar una opción de la lista',
            'payed.required' => 'Debe indicar el monto pagado',
            'payed.min' => 'Debe ser al menos :min',
            'payed.max' => 'Debe ser máximo :min',
            'payed.numeric' => 'Debe ser un número',
            'ref.required' => 'Debe indicar el número de referencia',
            'ref.min' => 'Debe ser al menos :min dígitos',
            'ref.max' => 'Debe ser máximo :min dígitos',
            'ref.regex' => 'Debe ser un número',
        ];
    }

    public function toggle()
    {
        $this->resetUI();
        $this->show_modal = ! $this->show_modal;
    }

    public function set_appointment(Appointment $record)
    {
        if ($this->selected_frequent_appointment === $record->id) {
            $this->selected_service = null;
            $this->selected_package = null;
            $this->selected_time = null;
            $this->selected_frequent_appointment = null;
        } else {
            $this->selected_service = $record->service_id;
            $this->selected_package = $record->package_id;
            $this->selected_time = explode(' ', $record->picked_date)[1];
            $this->selected_frequent_appointment = $record->id;
        }
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
        $this->registered_local = $record->registered_local;
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

        if ($this->status === '1') {
            $record->payment()->create(attributes: [
                'type' => TypeEnum::from($this->type),
                'payed' => $this->payed,
                'currency' => CurrencyEnum::from($this->currency),
                'ref' => $this->ref
            ]);
        }

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
                'picked_date' => $final_date,
                'discount' => $this->discount
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

        $user_appointments = Payment::whereHas('appointment', function ($query) {
            $query->where('user_id', auth()->id());
        })->count();

        $this->discount = $user_appointments % 4 === 0;

        if (Auth::user()->hasAnyRole('admin', 'employee')) {
            $this->clients = User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })->get();
        }
    }

    #[Layout('layouts.app')]

    public function render()
    {
        if (auth()->user()->hasRole('client')) {
            $this->frequent_appointments = Appointment::select(
                DB::raw('max(id) as last_id'),
                DB::raw('count(service_id) as services_count'),
                DB::raw('count(package_id) as packages_count'),
                DB::raw('DATE_FORMAT(picked_date, "%H:%i") as time')
            )
                ->where('user_id', auth()->id())
                ->groupBy('time')
                ->havingRaw('(count(service_id) > 3 OR count(package_id) > 3)')
                ->get();
        }

        $this->registered_local = auth()->user()->hasRole('admin');
        $appointments = Appointment::with('payment')
            ->orderByDesc('created_at')
            ->paginate($this->pagination);

        return view('livewire.appointments-component', [
            'appointments' => $appointments,
        ]);
    }
}
