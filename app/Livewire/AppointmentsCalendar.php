<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Omnia\LivewireCalendar\LivewireCalendar;

class AppointmentsCalendar extends LivewireCalendar
{
    protected $listeners = ['refreshParent' => '$refresh'];

    public function events(): Collection
    {
        $query = Auth::user()->hasRole('client')
            ?  Appointment::where('user_id', Auth::user()->id)
            ->whereNot('status', 1)
            ->get()
            : (Auth::user()->hasRole('employee')
                ? Appointment::where(function ($query) {
                    $query->whereNot('status', [1, 2])
                        ->whereHas('service', function ($q) {
                            $q->whereHas('employees', function ($q) {
                                $q->where('employee_id', Auth::user()->employee->id);
                            });
                        })->orWhereHas('package', function ($q) {
                            $q->whereHas('services', function ($q) {
                                $q->whereHas('employees', function ($q) {
                                    $q->where('employee_id', Auth::user()->employee->id);
                                });
                            });
                        });
                })->get()
                : Appointment::where(function ($query) {
                    $query->where('re_assigned', 1)
                        ->orWhereNot('status', 1);
                })
                ->get());

        return $query
            ->map(function (Appointment $appointment) {
                $option = $appointment->service ?? $appointment->package;

                if (!is_null($option)) {
                    return [
                        'id' => $appointment->id,
                        'title' => $option->name,
                        'description' => Carbon::createFromFormat('Y-m-d H:i:s', $appointment->picked_date)->format('h:i:s a'),
                        'date' => $appointment->picked_date,
                    ];
                }
            });
    }

    public function onDayClick($year, $month, $day)
    {
        $today = now()->yesterday()->format('Y-m-d');
        $day = $day < 10 ? "0$day" : $day;
        $month = $month < 10 ? "0$month" : $month;
        $date = "$year-$month-$day";

        if ($date > $today) {
            $this->dispatch('toggle');
            $this->dispatch('set_selected_day', $date);
        }
    }

    public function onEventClick($eventId)
    {
        $this->dispatch('edit', $eventId);
    }

    public function onEventDropped($eventId, $year, $month, $day)
    {
        if (Auth::user()->hasRole('client')) {
            return null;
        }

        $day = $day < 10 ? "0$day" : $day;
        $date = "$year-$month-$day";
        $today = now()->format('Y-m-d');

        if ($date < $today) {
            return null;
        }

        $record = Appointment::find($eventId);
        $time = explode(' ', $record->picked_date)[1];
        $record->update([
            'picked_date' => "$date $time"
        ]);
    }
}
