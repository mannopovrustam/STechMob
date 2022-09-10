<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function codes()
    {
        return $this->hasMany(ProductCode::class, 'product_id');
    }

    public function mark()
    {
        return $this->belongsTo(Mark::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product_codes()
    {
        return $this->hasMany(ProductCode::class);
    }

}
