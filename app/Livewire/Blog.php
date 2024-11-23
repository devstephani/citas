<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Blog extends Component
{
    public $title = 'Blog';
    public $subtitle = 'Contenido de Belleza';
    public $pagination = 15;

    #[Layout('layouts.app')]
    public function render()
    {
        $posts = Post::where('active', 1)
            ->orderByDesc('created_at')
            ->paginate($this->pagination);

        return view('livewire.blog', [
            'posts' => $posts,
            'title' => $this->title,
            'subtitle' => $this->subtitle
        ]);
    }
}
