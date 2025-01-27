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
            ->whereDoesntHave('favorites', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderByDesc('created_at')
            ->paginate($this->pagination);

        $user_favorite_posts = Post::where('active', 1)
            ->whereHas('favorites', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderByDesc('created_at')
            ->paginate($this->pagination);


        return view('livewire.blog', [
            'posts' => $posts,
            'favorites' => $user_favorite_posts,
            'title' => $this->title,
            'subtitle' => $this->subtitle
        ]);
    }
}
