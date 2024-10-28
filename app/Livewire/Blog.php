<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Blog extends Component
{
    public $title = 'Blog';
    public $subtitle = 'Contenido de Belleza';

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.blog');
    }
}
