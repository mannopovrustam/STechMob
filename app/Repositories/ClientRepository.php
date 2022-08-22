<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 11.08.2022
 * Time: 17:51
 */

namespace App\Repositories;


use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Models\Client;
use App\Models\User;

class ClientRepository extends CoreRepository implements ClientRepositoryInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return User::class;
    }

    public function allList($collection = []){}

    public function paginate($page, $array = null)
    {
        return $this->model()->with('client')
            ->where('role', User::USER_ROLE['client'])
            ->filter($array)->search($array)->paginate($page);
    }

    public function details($collection = []){}


}