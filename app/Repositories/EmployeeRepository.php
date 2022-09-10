<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 12.08.2022
 * Time: 15:52
 */

namespace App\Repositories;

use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Repositories\WarehouseRepositoryInterface;
use App\Models\Employee;
use App\Models\User;
use App\Models\Warehouse;

class EmployeeRepository extends CoreRepository implements EmployeeRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getModelClass()
    {
        return User::class;
    }

    public function allList($collection = []){}

    public function paginate($paginate, $array = null)
    {
        return $this->model()->with('employee', 'mainCurrency', 'secondCurrency')->where('role', User::USER_ROLE['employee'])->filter($array)->paginate($paginate);
    }

    public function details($collection = []){}

}