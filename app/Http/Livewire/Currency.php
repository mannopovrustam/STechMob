<?php

namespace App\Http\Livewire;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Services\CurrencyService\CurrencyService;
use Livewire\Component;

class Currency extends Component
{
    public $currencies, $currency = [], $currencyPopup = 'false', $currencyInputs = [], $currencyInputsLoop = 0;

    public function mount()
    {
        $this->currencies = \App\Models\Currency::all();

        foreach ($this->currencies as $key => $currency) {
            $this->currency[$key]['id'] = $currency->id;
            $this->currency[$key]['title'] = $currency->title;
            $this->currency[$key]['rate'] = $currency->rate;
        }
    }
    public function render()
    {
        return view('livewire.currency');
    }

    public function addCurrency($expenseInputsLoop)
    {
        $this->currencyInputsLoop = $expenseInputsLoop + 1;
        $this->currencyInputs[(int)$this->currencyInputsLoop] = $this->currencyInputsLoop;
    }

    public function removeCurrency($currencyInputsLoop)
    {
        unset($this->currencyInputs[$currencyInputsLoop]);
        unset($this->currency[$currencyInputsLoop]);
    }

    public function storeCurrency(CurrencyServiceInterface $service)
    {
        foreach ($this->currency as $item){
            $currencyStore = $service->createOrUpdate($item);
            session()->flash('checkCurrency', $currencyStore['message'] ?? null);
        }
        $this->render();
    }

}
