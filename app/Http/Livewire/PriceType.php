<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\PriceTypeRepositoryInterface;
use App\Contracts\Services\PriceTypeServiceInterface;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Pricing;

class PriceType extends Component
{
    use WithFileUploads;

    public $addPriceType = 'false', $popupPricing = 'false', $collection = [];
    private $allPriceTypes = [];

    public function render(PriceTypeRepositoryInterface $repository)
    {
        $this->allPriceTypes = $repository->paginate(10);
        return view('livewire.price-type', ['allPriceTypes' => $this->allPriceTypes]);
    }

    public function addPriceType(PriceTypeServiceInterface $service)
    {
        $status = $service->createOrUpdate($this->collection);
        if (isset($status['message'])){
            session()->flash('checkPriceType', $status['message']);
        }else{
            unset($this->collection);
            session()->flash('checkPriceType', $status['code']);
        }
    }

    public function editPriceType($array)
    {
        $this->collection['id'] = $array['id'];
        $this->collection['name'] = $array['name'];
        $this->addPriceType = 'true';
    }

    public function addPricing($item)
    {
        $this->collection['price_type_id'] = $item;
        $this->popupPricing = 'true';
    }

    public function currencyChange()
    {
        unset($this->collection['second_currency']);
    }

    public function storePricing()
    {
        Excel::import(new Pricing($this->collection['price_type_id']), $this->collection['pricing']);
    }
}
