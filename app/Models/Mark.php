<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function priceTypeWarehouse()
    {
        return $this->hasMany(PriceTypeWarehouse::class, 'mark_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function priceTypes()
    {
        return $this->belongsToMany(PriceType::class)->withTimestamps();
    }

    public function scopeFilter($value, $array)
    {
        return $value
            ->when(isset($array['active']), function ($q) use ($array) {
                $q->whereActive($array['active']);
            })
            ->when(isset($array['length']), function ($q) use ($array) {
                $q->skip($array['start'] ?? 0)->take($array['length']);
            })
            ->when(isset($array['length']), function ($q) use ($array) {
                $q->skip($array['start'] ?? 0)->take($array['length']);
            });
    }

}
