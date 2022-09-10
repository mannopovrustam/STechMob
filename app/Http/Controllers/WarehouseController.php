<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\WarehouseRepositoryInterface;
use App\Contracts\Services\WarehouseServiceInterface;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    protected $repository, $service;
    public function __construct(WarehouseRepositoryInterface $repository, WarehouseServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->repository->allList();
        return view('admin.management.warehouse.warehouse', compact('data'));
    }
    public function store()
    {

    }
}
