<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Client extends Component
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
        $clients = User::whereHas('roles', function ($query) {
            $query->where('name', 'client');
        })
            ->get();

        return response()->streamDownload(function () use ($clients, $image) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.clients', [
                'clients' => $clients,
                'image' => $image
            ]);
            echo $pdf->stream();
        }, "Reporte de Clientes.pdf");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $data = User::where(function ($query) {
            $query->where('name', 'like', '%' . $this->query . '%')
                ->orWhere('email', 'like', '%' . $this->query . '%');
        })
            ->with('roles')
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['client']);
            })
            ->orderByDesc('created_at')
            ->paginate($this->pagination);

        return view('livewire.client', [
            'clients' => $data,
            'title' => 'Clientes'
        ]);
    }
}
