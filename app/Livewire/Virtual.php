<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Virtual extends Component
{
    public $title = 'Probador';
    public $subtitle = 'Probador Virtual';

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.virtual');
    }
}
