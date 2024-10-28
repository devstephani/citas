<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Packages extends Component
{
    public $title = 'Paquetes';
    public $subtitle = 'Paquetes Disponibles';

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.packages');
    }
}
