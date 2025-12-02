<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.marketing')]
class Payment extends Component
{
    public function render()
    {
        return view('livewire.payment');
    }
}
