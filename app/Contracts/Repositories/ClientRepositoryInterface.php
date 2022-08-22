<?php

namespace App\Contracts\Repositories;


interface ClientRepositoryInterface
{
    public function allList($collection = []);
    public function paginate($page, $collection = []);
    public function details($collection = []);
}