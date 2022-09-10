<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    const INVOICE_TYPE = [
        'order' => 'O',
        'shipment' => 'S'
    ];

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function product_expenses()
    {
        return $this->hasMany(ProductExpense::class);
    }
    public function money_invoices()
    {
        return $this->hasMany(MoneyInvoice::class);
    }

    public function generateInvoice($formerReference = "AA-0000000")
    {
        if (count(explode("-", $formerReference)) == 1){
            $formerReference = 'AA-0000000';
        }
        $parts = explode("-", $formerReference);
        $numbers = $parts[1];
        $letters = $parts[0];

        if($numbers == "9999999"){
            $nextLetters = ++$letters;
            $nextNumbers = 1;
        } else {
            $nextLetters = $letters;
            $nextNumbers = ++$numbers;
        }

        $nextReference = $nextLetters."-".sprintf('%07d', $nextNumbers);

        return $nextReference;
    }

}
