<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 25.08.2022
 * Time: 9:33
 */

namespace App\Traits;


use App\Models\Currency;

trait Currenciable
{
    public function currencies()
    {
        $currency = $this->morphToMany(Currency::class, 'currenciable')->withPivot('default')->orderBy('currenciables.default', 'desc');
        return $currency ?? null;
    }
    public function mainCurrency()
    {
        return $this->morphToMany(Currency::class, 'currenciable')->wherePivot('default',1) ?? null;
    }
    public function secondCurrency()
    {
        return $this->morphToMany(Currency::class, 'currenciable')->wherePivot('default',0) ?? null;
    }
}