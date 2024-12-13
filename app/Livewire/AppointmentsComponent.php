<?php

namespace App\Livewire;

use App\Enum\Payment\CurrencyEnum;
use App\Enum\Payment\TypeEnum;
use App\Models\Appointment;
use App\Models\Binnacle;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use App\Rules\OneRequired;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Snowfire\Beautymail\Beautymail;

class AppointmentsComponent extends Component
{
    #[Url]
    public $service_id, $package_id;
    public $show_modal = false, $discount = false, $currentTimeFormatted, $modifying;
    public $id = 0, $currency_api = 0, $client_name, $client_id = null, $clients, $services, $packages, $selected_service = 0, $selected_package = 0, $m_service, $m_package, $selected_date, $selected_time, $status, $registered_local, $type, $currency, $ref, $frequent_appointments, $selected_frequent_appointment, $note = null;

    private $pagination = 20;
    protected $listeners = ['toggle', 'set_selected_day', 'edit', 'delete', 'set_appointment', 'rate', 'confirm', 'modify'];

    public $hours = [
        ['value' => '08:00:00', 'text' => '08:00 am'],
        // ['value' => '09:00:00', 'text' => '09:00 am'],
        ['value' => '10:00:00', 'text' => '10:00 am'],
        // ['value' => '11:00:00', 'text' => '11:00 am'],
        ['value' => '12:00:00', 'text' => '12:00 pm'],
        // ['value' => '01:00:00', 'text' => '01:00 pm'],
        ['value' => '14:00:00', 'text' => '02:00 pm'],
        // ['value' => '03:00:00', 'text' => '03:00 pm'],
        ['value' => '16:00:00', 'text' => '04:00 pm'],
        // ['value' => '05:00:00', 'text' => '05:00 pm'],
        ['value' => '18:00:00', 'text' => '06:00 pm'],
        // ['value' => '07:00:00', 'text' => '07:00 pm'],
    ];

    public function rules()
    {
        return [
            'selected_service' => ['nullable', new OneRequired('selected_package'), 'exists:services,id'],
            'selected_package' => ['nullable', new OneRequired('selected_service'), 'exists:packages,id'],
            'selected_time' => ['required', 'date_format:H:i:s'],
            'status' => [
                Rule::when(Auth::user()->hasRole('admin') && $this->id > 0, 'required|integer|min:0|max:2')
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
            'ref' => [
                'sometimes',
                Rule::when($this->type === 'MOBILE' || $this->type === 'PAYPAL', 'required|digits_between:3,8|regex:/^[0-9]+$/')
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
            'ref.required' => 'Debe indicar el número de referencia',
            'ref.digits_between' => 'Debe entre :min y :max dígitos',
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
        $this->note = $record->note;
        $this->registered_local = $record->registered_local;
        $this->ref = $record->payment->ref;
        $this->currency = $record->payment->currency->value;
        $this->type = $record->payment->type->value;
        $this->modifying = $record->re_assigned;
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
            'status' => $this->status,
            'note' => $this->note,
            're_assigned' => 0,
        ]);
        $record->payment()->update([
            'currency' => $this->currency,
            'type' => $this->type,
            'ref' => $this->ref,
            'currency_api' => $this->currency_api
        ]);

        if ($this->status === '1') {
            $beautymail = app()->make(Beautymail::class);
            $beautymail->send('emails.appointment-payed', [
                'appointment' => $record
            ], function ($message) use ($record) {
                $message
                    ->from(env('MAIL_FROM_ADDRESS'))
                    ->to($record->user->email)
                    ->subject('Cita finalizada y pagada');
            });
        }

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'success',
            'message' => "Se actualizó la cita de {$record->user->name}"
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
        $today = now()->format('Y-m-d');
        $selected_date = \Carbon\Carbon::createFromFormat('Y-m-d', $date)
            ->dayOfWeek;

        $this->hours = $this->getAvailableHours($selected_date);

        $date > $today
            ? $this->currentTimeFormatted = null
            : $this->currentTimeFormatted = now()->format('H:i:s');
    }

    public function save()
    {
        $final_date = "$this->selected_date $this->selected_time";

        $occupied = Appointment::where('picked_date', '=', $final_date)
            ->where(function ($query) {
                $query->whereNotNull('service_id')
                    ->where('service_id', $this->selected_service)
                    ->orWhere(function ($query) {
                        $query->whereNotNull('package_id')
                            ->where('package_id', $this->selected_package);
                    });
            })
            ->exists();

        if (!$occupied) {
            $this->validate();

            $user = User::find($this->client_id ?? Auth::user()->id);
            Appointment::create([
                'status' => 0,
                'user_id' => $user->id,
                'service_id' => $this->selected_service ?? null,
                'package_id' => $this->selected_package ?? null,
                'picked_date' => $final_date,
                'discount' => $this->discount
            ])->payment()->create([
                'currency' => $this->currency,
                'type' => $this->type,
                'ref' => $this->ref,
                'currency_api' => $this->currency_api
            ]);

            Binnacle::create([
                'user_id' => auth()->id(),
                'status' => 'success',
                'message' => "Se registró la cita de {$user->name}"
            ]);

            $this->resetUI();
            $this->package_id = null;
            $this->service_id = null;
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

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'success',
            'message' => "Se eliminó la cita de {$record->user->name}"
        ]);

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
        $this->note = null;
        $this->currency = null;
        $this->type = null;
        $this->ref = null;
        $this->modifying = null;
    }

    public function getAvailableHours($today)
    {
        $availableHours = [];

        if ($today === 0) {
            $availableHours = [
                ['value' => '09:00:00', 'text' => '09:00 am'],
                // ['value' => '10:00:00', 'text' => '10:00 am'],
                ['value' => '11:00:00', 'text' => '11:00 am'],
                // ['value' => '12:00:00', 'text' => '12:00 pm'],
                ['value' => '13:00:00', 'text' => '01:00 pm'], // 13:00 for 1 PM
                // ['value' => '14:00:00', 'text' => '02:00 pm']
            ];
        } elseif (in_array($today, [1, 2, 3, 4])) {
            $availableHours = [
                ['value' => '09:00:00', 'text' => '09:00 am'],
                // ['value' => '10:00:00', 'text' => '10:00 am'],
                ['value' => '11:00:00', 'text' => '11:00 am'],
                // ['value' => '12:00:00', 'text' => '12:00 pm'],
                ['value' => '13:00:00', 'text' => '01:00 pm'],
                // ['value' => '14:00:00', 'text' => '02:00 pm'],
                ['value' => '15:00:00', 'text' => '03:00 pm'],
                // ['value' => '16:00:00', 'text' => '04:00 pm'],
                ['value' => '17:00:00', 'text' => '05:00 pm']
            ];
        } elseif (in_array($today, [5, 6])) {
            return $this->hours;
        }

        return $availableHours;
    }

    public function mount()
    {
        $response = Http::get('https://pydolarve.org/api/v1/dollar?monitor=bcv');
        if ($response->status() === 200 && !$response->failed()) {
            $data = json_decode($response->body());
            $this->currency_api = $data->price;
        }

        $today = now()->today()->dayOfWeek;
        $this->hours = $this->getAvailableHours($today);

        $user = auth()->user();
        $this->services = $user->hasRole('admin')
            ? Service::where('active', 1)->get()
            : (
                $user->hasRole('employees')
                ? Service::with('employees')
                ->whereHas('employees', function ($query) use ($user) {
                    $query->where('employee_id', $user->employee->id);
                })
                ->where('active', 1)
                ->get()
                : Service::where('active', 1)->get()
            );
        $this->packages = Package::where('active', 1)->get();

        $user_appointments = Payment::whereHas('appointment', function ($query) {
            $query->where('user_id', auth()->id());
        })->count();

        $this->discount = $user_appointments % 4 === 0;

        if ($user->hasAnyRole('admin', 'employee')) {
            $this->clients = User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })->get();
        }
    }

    public function rate(int $stars, Appointment $record)
    {
        $record->update(['stars' => $stars]);
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $record->picked_date)
            ->format('d-m-Y h:i:s a');
        $name = $record->service->name ?? $record->package->name;

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'info',
            'message' => "Puntuó la cita de {$name} del día {$date}"
        ]);
    }

    public function confirm(Appointment $record)
    {
        $record->update(['accepted' => 1]);
    }

    public function modify(Appointment $record)
    {
        $record->update(['re_assigned' => 1]);
    }

    #[Layout('layouts.app')]

    public function render()
    {
        if (!is_null($this->package_id) && $this->package_id !== '') {
            $this->selected_package = $this->package_id;
        }
        if (!is_null($this->service_id) && $this->service_id !== '') {
            $this->selected_service = $this->service_id;
        }

        $this->m_service = Service::find($this->selected_service);
        $this->m_package = Package::find($this->selected_package);

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
        $appointments = [];
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            $appointments = Appointment::with('payment')
                ->where(function ($query) {
                    $query->whereNull('re_assigned')
                        ->orWhere('re_assigned', 0);
                })
                ->orderByDesc('created_at')
                ->paginate($this->pagination);
        }

        if ($user->hasRole('employee')) {
            $appointments = Appointment::with(['payment', 'service', 'service.employees'])
                ->whereHas('service', function ($query) use ($user) {
                    $query->whereHas('employees', function ($query) use ($user) {
                        $query->where('employee_id', $user->employee->id);
                    });
                })
                ->orderByDesc('created_at')
                ->paginate($this->pagination);
        }


        if ($user->hasRole('client')) {
            $appointments = Appointment::with('payment')
                ->where('user_id', $user->id)
                ->whereIn('status', [1, 2])
                ->orderByDesc('created_at')
                ->paginate($this->pagination);
        }

        return view('livewire.appointments-component', [
            'appointments' => $appointments,
        ]);
    }
}
