<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferable extends Model
{
    use HasFactory;

    const STATUS = [
        'must' => -1,
        'waiting' => 0,
        'success' => 1,
        'ignore' => 2,
    ];

    protected $guarded = [];

    const TYPE = [
        'receiver' => 1,
        'sender' => -1
    ];
}
