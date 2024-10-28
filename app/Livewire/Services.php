<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Services extends Component
{
    public $title = 'Servicios';
    public $subtitle = 'Servicios Disponibles';

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.services');
    }
}
