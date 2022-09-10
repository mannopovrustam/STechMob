<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currenciable extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function currencies()
    {
        return $this->morphedByMany(Currency::class, 'currenciable');
    }
    public function employees()
    {
        return $this->morphedByMany(Employee::class, 'currenciable');
    }
}
