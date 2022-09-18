<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    const TRADE_TYPE = [
        'cash' => 1,
        'loan' => 2,
        'installment' => 3,
        'income' => 4,
        'transfer' => 5,
    ];

    const TRADE_TYPE_NAME = [
        'cash' => 'Naqd',
        'loan' => 'Nasiya',
        'installment' => "Muddatli to'lov",
        'income' => 'Kirim',
        'transfer' => "O'tkazma",
    ];

    const PAYMENT_TERM_TYPE = [
        'hour' => 1,
        'day' => 2,
        'month' => 3,
        'year' => 4,
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

}
