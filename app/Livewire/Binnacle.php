<?php

namespace App\Livewire;

use App\Models\Binnacle as ModelsBinnacle;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Binnacle extends Component
{
    public function mount()
    {
        if (auth()->user()->hasRole('client')) {
            return redirect()->route('home');
        }
        if (auth()->user()->hasRole('employee')) {
            return redirect()->route('dashboard');
        }
    }

    #[Layout('layouts.app')]

    public function render()
    {
        $logs = ModelsBinnacle::paginate(perPage: 20);
        return view('livewire.binnacle', [
            'logs' => $logs
        ]);
    }
}
