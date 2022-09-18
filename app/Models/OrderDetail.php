<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PAYMENT_TERM_TYPE = [
        'kun' => '1',
        'hafta' => '2',
        'oy' => '3',
        'yil' => '4'
    ];

    public function installment_detail()
    {
        return $this->hasMany(InstallmentDetail::class);
    }
}
