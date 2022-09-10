<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
    public function priceTypeWarehouse()
    {
        return $this->hasMany(PriceTypeWarehouse::class);
    }

    public function marks()
    {
        return $this->belongsToMany(Mark::class, PriceTypeWarehouse::class)
            ->withTimestamps();
    }

    public function currencies()
    {
        return $this->belongsToMany(Currency::class, PriceTypeWarehouse::class)
            ->withTimestamps();
    }


    public function scopeFilter()
    {
        //
    }
}
