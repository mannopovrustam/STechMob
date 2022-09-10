<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Pay extends Component
{
    public $pay;

    public function mount($pay)
    {
//        dd($pay);
        $this->pay = $pay;
    }

    public function render()
    {
//        dd($this->pay);
        return view('livewire.pay');
    }
}
