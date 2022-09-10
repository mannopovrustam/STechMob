<?php

namespace App\Contracts\Repositories;


interface PriceTypeRepositoryInterface
{
    public function allList($collection = []);
    public function paginate($page, $collection = []);
    public function details($id);
}