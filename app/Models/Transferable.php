<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferable extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS = [
        'waiting' => 0,
        'success' => 1,
        'ignore' => 2,
    ];
}
