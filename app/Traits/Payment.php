<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 07.09.2022
 * Time: 12:43
 */

namespace App\Traits;


use App\Models\Currency;
use App\Models\User;

trait Payment
{

    public $currency = [], $offer = [], $getSum = 0;

    public function sumPay($totalSum)
    {
        $mainCurrency = User::getCurrency()->first();
        $baseCurrency = Currency::all()->toArray();

        $this->getSum = collect($this->currency)->map(function ($item, $key) use ($baseCurrency,$mainCurrency) {
            return (double)($item ?? 0)/(double)collect($baseCurrency)->firstWhere('id',$key)['rate']*(double)$mainCurrency->rate;
        })->sum();

        foreach (User::getCurrency() as $value){
            $this->offer[$value->id] = ($totalSum - $this->getSum)/$mainCurrency->rate*collect($baseCurrency)->firstWhere('id',$value->id)['rate'];
        }
    }

}