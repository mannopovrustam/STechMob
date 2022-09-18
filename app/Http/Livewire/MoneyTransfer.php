<?php

namespace App\Http\Livewire;

use App\Models\Transferable;
use App\Models\User;
use App\Services\MoneyService\MoneyService;
use Livewire\Component;

class MoneyTransfer extends Component
{
    public $addTransfer = 'false', $allTransfers;
    public $collection;

    public function render()
    {
        $this->allTransfers = Transferable::where([['warehouse_id', User::getWarehouse()->id], ['transferable_type', \App\Models\MoneyTransfer::class]])->get();

        return view('livewire.money-transfer');
    }

    public function storeTransfer()
    {
        (new MoneyService())->transfer($this->collection);
    }
}
