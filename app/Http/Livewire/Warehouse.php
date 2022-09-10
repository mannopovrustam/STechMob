<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\WarehouseRepositoryInterface;
use App\Contracts\Services\WarehouseServiceInterface;
use Livewire\Component;

class Warehouse extends Component
{
    public $addWarehouse = 'false', $collection = [];
    private $allWarehouses = [];

    public function render(WarehouseRepositoryInterface $repository)
    {
        $this->allWarehouses = $repository->paginate(10);
        return view('livewire.warehouse', ['allWarehouses' => $this->allWarehouses]);
    }

    public function addWarehouse(WarehouseServiceInterface $service)
    {
        if (isset($this->collection['second_currency'])){
            foreach ($this->collection['second_currency'] as $key => $value){
                if ($this->collection['second_currency'][$key] == false){
                    unset($this->collection['second_currency'][$key]);
                }
            }
        }

        $status = $service->createOrUpdate($this->collection);
        if (isset($status['message'])){
            session()->flash('checkWarehouse', $status['message']);
        }else{
            session()->flash('checkWarehouse', $status['code']);
        }
    }

    public function editWarehouse($array)
    {
        $this->collection['id'] = $array['id'];
        $this->collection['name'] = $array['name'];
        $this->collection['address'] = $array['address'];
        $this->collection['price_type_id'] = $array['price_type_id'];
        if (isset($this->collection['currency'])){
            $this->collection['currency'] = $array['main_currency'][0]['id'];
            foreach ($array['second_currency'] as $key => $item) {
                $this->collection['second_currency'][$key] = $item['id'];
            }
        }
        $this->addWarehouse = 'true';
    }


    public function currencyChange()
    {
        unset($this->collection['second_currency']);
    }

}
