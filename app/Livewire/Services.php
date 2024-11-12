<?php

namespace App\Livewire;

use App\Models\Service;
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
    protected $listeners = ['clear', 'refreshParent' => '$refresh'];

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
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $data = Service::where(function ($query) {
            $query->where('name', 'like', '%' . $this->query . '%')
                ->orWhere('description', 'like', '%' . $this->query . '%')
                ->orWhere('type', 'like', '%' . $this->query . '%');
        })
            ->orderByDesc('created_at')
            ->paginate($this->pagination);


        return view('livewire.services', [
            'services' => $data,
        ]);
    }
}
