<?php

namespace App\Livewire;

use App\Models\User;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    protected function rand_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    #[Layout('layouts.app')]
    public function render()
    {
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

        $months = [
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
        $client_bar_chart = (new ColumnChartModel())
            ->setTitle('Clientes registrados');

        foreach ($clients as $key => $value) {
            $client_bar_chart->addColumn($months[$key], $value->qty, $this->rand_color());
        }
        $employee_bar_chart = (new ColumnChartModel())
            ->setTitle('Empleados registrados');

        foreach ($employees as $key => $value) {
            $employee_bar_chart->addColumn($months[$key], $value->qty, $this->rand_color());
        }

        return view('livewire.dashboard', [
            'client_bar_chart' => $client_bar_chart,
            'employee_bar_chart' => $employee_bar_chart,
        ]);
    }
}
