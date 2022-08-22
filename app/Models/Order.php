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
    ];

    const TRADE_TYPE_NAME = [
        'cash' => 'Naqd',
        'loan' => 'Nasiya',
        'installment' => "Muddatli to'lov",
        'income' => 'Kirim',
    ];
}
