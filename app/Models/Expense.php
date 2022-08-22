<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $guarded = [];

    const TYPE = [
        'total' => 1,
        'piece' => 2,
        'total%' => 3,
        'distribution' => 4
    ];
}
