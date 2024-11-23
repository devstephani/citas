<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component
{
    use WithPagination;
    public $title = 'Servicios';
    public $subtitle = 'Servicios Disponibles';

    public $data;
    public $query = '';
    private $pagination = 20;
    protected $listeners = ['clear', 'refreshParent' => '$refresh', 'pdf'];

    public function clear()
    {
        $this->query = '';
        $this->dispatch('$refresh');
    }

    public function pdf()
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.jpg')));
        $services = Appointment::with(['service', 'user', 'payment'])
            ->where('service_id', '!=', null)
            ->whereYear('picked_date', '=', now()->format('Y'))
            ->get();

        return response()->streamDownload(function () use ($services, $image) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.services', [
                'services' => $services,
                'image' => $image
            ]);
            echo $pdf->stream();
        }, "Reporte de servicios.pdf");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = auth()->user()->hasRole('admin')
            ? Service::where(function ($query) {
                $query->where('name', 'like', '%' . $this->query . '%')
                    ->orWhere('description', 'like', '%' . $this->query . '%')
                    ->orWhere('type', 'like', '%' . $this->query . '%');
            })
            : Service::where('active', 1);
        $data = $query
            ->orderByDesc('created_at')
            ->paginate($this->pagination);


        return view('livewire.services', [
            'services' => $data,
        ]);
    }
}
