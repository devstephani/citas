<?php

namespace App\Livewire;

use App\Models\Attendance;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    public $data;
    public $query = '';
    private $pagination = 20;
    protected $listeners = ['clear', 'refreshParent' => '$refresh', 'pdf'];

    public function clear()
    {
        $this->query = '';
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        if (auth()->user()->hasRole('client')) {
            return redirect()->route('home');
        }
        if (auth()->user()->hasRole('employee')) {
            return redirect()->route('dashboard');
        }
    }

    public function pdf()
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.jpg')));
        $attendances = Attendance::all();
        return response()->streamDownload(function () use ($attendances, $image) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.employee', [
                'attendances' => $attendances,
                'image' => $image
            ]);
            echo $pdf->stream();
        }, "Asistencia de empleado.pdf");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $data = \App\Models\Employee::with('user')
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->query . '%')
                    ->orWhere('email', 'like', '%' . $this->query . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($this->pagination);

        return view('livewire.employee', [
            'employees' => $data,
            'title' => 'Empleados'
        ]);
    }
}
