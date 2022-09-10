<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Currenciable;

class Currency extends Model
{
    use HasFactory, Currenciable;
    protected $guarded = [];

    public function users()
    {
        return $this->morphedByMany(User::class, 'currenciable');
    }

    public function priceTypes()
    {
        return $this->belongsToMany(PriceType::class)->withTimestamps();
    }

}
