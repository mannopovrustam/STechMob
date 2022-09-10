<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\PriceTypeRepositoryInterface;
use Livewire\Component;

class Pricing extends Component
{
    public $popupPricing = 'false', $collection = [], $priceTypeId;
    private $allPricing = [];

    public function mount($id)
    {
        $this->priceTypeId = $id;
    }

    public function render(PriceTypeRepositoryInterface $repository)
    {
        $this->allPricing = $repository->details($this->priceTypeId);
        return view('livewire.pricing', ['allPriceTypes' => $this->allPricing]);
    }
}
