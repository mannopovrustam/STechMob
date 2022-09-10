<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 12.08.2022
 * Time: 15:52
 */

namespace App\Repositories;

use App\Contracts\Repositories\PriceTypeRepositoryInterface;
use App\Models\PriceType;

class PriceTypeRepository extends CoreRepository implements PriceTypeRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getModelClass()
    {
        return PriceType::class;
    }

    public function allList($collection = []){}

    public function paginate($page, $array = null)
    {
        return $this->model()->filter($array)->paginate($page);
    }

    public function details($id){
        $this->model()->find($id);
    }

}