<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Package;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Packages extends Component
{
    public $title = 'Paquetes';
    public $subtitle = 'Paquetes Disponibles';
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
        $packages = Appointment::with(['package', 'user', 'payment'])
            ->where('package_id', '!=', null)
            ->whereYear('picked_date', '=', now()->format('Y'))
            ->get();

        return response()->streamDownload(function () use ($packages, $image) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.packages', [
                'packages' => $packages,
                'image' => $image
            ]);
            echo $pdf->stream();
        }, "Reporte de servicios.pdf");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = auth()->user()->hasRole('admin')
            ? Package::where(function ($query) {
                $query->where('name', 'like', '%' . $this->query . '%')
                    ->orWhere('description', 'like', '%' . $this->query . '%');
            })
            : Package::where('active', 1);

        $data = $query
            ->orderByDesc('created_at')
            ->paginate($this->pagination);

        return view('livewire.packages', [
            'packages' => $data
        ]);
    }
}
