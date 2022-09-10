<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function money_transfers()
    {
        return $this->hasMany(MoneyTransfer::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
