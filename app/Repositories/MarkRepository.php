<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 12.08.2022
 * Time: 15:52
 */

namespace App\Repositories;

use App\Contracts\Repositories\MarkRepositoryInterface;
use App\Models\Mark;

class MarkRepository extends CoreRepository implements MarkRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getModelClass()
    {
        return Mark::class;
    }

    public function allList($collection = []){}

    public function paginate($page, $array = null)
    {
        return $this->model->with('type', 'brand')->filter($array)->paginate($page);
    }

    public function details($collection = []){}

}