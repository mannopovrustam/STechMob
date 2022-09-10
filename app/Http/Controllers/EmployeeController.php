<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Services\EmployeeServiceInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $repository, $service;
    public function __construct(EmployeeRepositoryInterface $repository, EmployeeServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->repository->allList();
        return view('admin.management.employee.employee', compact('data'));
    }
    public function store()
    {

    }

}
