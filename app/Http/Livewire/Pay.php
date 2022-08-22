<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Pay extends Component
{
    public $pay;

    public function mount($pay)
    {
        $this->pay = $pay;
    }

    public function render()
    {
        return view('livewire.pay');
    }
}
