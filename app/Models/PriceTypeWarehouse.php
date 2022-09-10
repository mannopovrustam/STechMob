<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceTypeWarehouse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function priceType()
    {
        return $this->belongsTo(PriceType::class);
    }
    public function mark()
    {
        return $this->belongsTo(Mark::class);
    }
}
