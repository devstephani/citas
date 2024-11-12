<?php

namespace App\Livewire;

use App\Models\Post as ModelsPost;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Post extends Component
{
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

        $data = ModelsPost::where(function ($query) {
            $query->where('title', 'like', '%' . $this->query . '%');
        })
            ->orderByDesc('created_at')
            ->paginate($this->pagination);

        return view('livewire.post', [
            'posts' => $data,
            'title' => 'Blog'
        ]);
    }
}
