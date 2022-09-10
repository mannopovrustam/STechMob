<?php

namespace App\Contracts\Repositories;


interface EmployeeRepositoryInterface
{
    public function allList($collection = []);
    public function paginate($paginate, $collection = []);
    public function details($collection = []);
}