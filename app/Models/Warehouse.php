<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;

class Warehouse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getWarehouse()
    {
        return self::find(session()->get('warehouse_id'));
    }
    public static function getId(): int
    {
        return session()->get('warehouse_id');
    }

}
