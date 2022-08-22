<?php

namespace App\Contracts\Repositories;


interface MarkRepositoryInterface
{
    public function allList($collection = []);
    public function paginate($page, $collection = []);
    public function details($collection = []);
}