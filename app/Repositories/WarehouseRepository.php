<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 12.08.2022
 * Time: 15:52
 */

namespace App\Repositories;

use App\Contracts\Repositories\WarehouseRepositoryInterface;
use App\Models\Warehouse;

class WarehouseRepository extends CoreRepository implements WarehouseRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getModelClass()
    {
        return Warehouse::class;
    }

    public function allList($collection = []){}

    public function paginate($page, $array = null)
    {
        return $this->model()->with('mainCurrency', 'secondCurrency')->filter($array)->paginate($page);
    }

    public function details($collection = []){}

}