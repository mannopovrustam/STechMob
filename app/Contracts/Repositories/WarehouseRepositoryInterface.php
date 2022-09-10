<?php

namespace App\Contracts\Repositories;


interface WarehouseRepositoryInterface
{
    public function allList($collection = []);
    public function paginate($page, $collection = []);
    public function details($collection = []);
}