<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Client extends Component
{
    use WithPagination;
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
