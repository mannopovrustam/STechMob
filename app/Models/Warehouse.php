<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;
use \App\Traits\Currenciable;

class Warehouse extends Model
{
    use HasFactory, Currenciable;

    protected $guarded = [];

    public static function getWarehouse()
    {
        if (session()->get('warehouse')){
            return Warehouse::find(session()->get('warehouse'));
        }else{
            return auth()->user()->warehouses->whereDefault(1)->first();
        }
    }
    public static function getId(): int
    {
        if (session()->get('warehouse')){
            return session()->get('warehouse');
        }else{
            return User::find(auth()->id())->warehouses->where('default',1)->first()->id;
        }
    }

    public function priceType()
    {
        return $this->belongsTo(PriceType::class);
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'warehouse_users',
            'warehouse_id',
            'user_id');
    }

    public function scopeFilter($array)
    {
        
    }

}
