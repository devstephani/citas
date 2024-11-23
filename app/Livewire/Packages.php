<?php

namespace App\Livewire;

use App\Models\Package;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Packages extends Component
{
    public $title = 'Paquetes';
    public $subtitle = 'Paquetes Disponibles';
    public $data;
    public $query = '';
    private $pagination = 20;
    protected $listeners = ['clear', 'refreshParent' => '$refresh'];

    public function clear()
    {
        $this->query = '';
        $this->dispatch('$refresh');
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
