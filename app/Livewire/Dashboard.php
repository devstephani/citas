<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Service;
use App\Models\User;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    protected $colors = ['#c8c8c8', '#f0c571', '#59a89c', '#0b81a2', '#e25759', '#9d2c00', '#7e4794', '#36b700', '#ffcd8e', '#ffb255', '#8fd7d7', '#00b0be'];
    protected $months = [
        'Ene',
        'Feb',
        'Mar',
        'Abr',
        'May',
        'Jun',
        'Jul',
        'Ago',
        'Sep',
        'Oct',
        'Nov',
        'Dic',
    ];

    #[Layout('layouts.app')]
    public function render()
    {
        $services_count = Service::count();
        $packages_count = Package::count();
        $employees_count = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['employee']);
        })->count();
        $clients_count = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['client']);
        })->count();

        $clients = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['client']);
        })
            ->select(
                DB::raw('count(id) as qty'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as n_date")
            )
            ->groupBy('n_date')
            ->orderBy('n_date')
            ->get();
        $employees = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['employee']);
        })
            ->select(
                DB::raw('count(id) as qty'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as n_date")
            )
            ->groupBy('n_date')
            ->orderBy('n_date')
            ->get();

        $client_bar_chart = (new ColumnChartModel())
            ->setTitle('Clientes registrados');

        foreach ($clients as $key => $value) {
            $client_bar_chart->addColumn($this->months[$key], $value->qty, $this->colors[$key]);
        }
        $employee_bar_chart = (new ColumnChartModel())
            ->setTitle('Empleados registrados');

        foreach ($employees as $key => $value) {
            $employee_bar_chart->addColumn($this->months[$key], $value->qty, $this->colors[$key]);
        }

        return view('livewire.home', [
            'client_bar_chart' => $client_bar_chart,
            'employee_bar_chart' => $employee_bar_chart,
            'services_count' => $services_count,
            'packages_count' => $packages_count,
            'employees_count' => $employees_count,
            'clients_count' => $clients_count,
            '' => $packages_count
        ]);
    }
}
