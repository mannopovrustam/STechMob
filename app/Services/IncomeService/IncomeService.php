<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 11.08.2022
 * Time: 17:24
 */

namespace App\Services\IncomeService;


use App\Models\Product;
use App\Services\CoreService;

class IncomeService extends CoreService
{
    protected function getModelClass()
    {
        return Product::class;
    }


}