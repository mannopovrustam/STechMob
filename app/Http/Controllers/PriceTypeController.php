<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\PriceTypeRepositoryInterface;
use App\Contracts\Services\PriceTypeServiceInterface;
use Illuminate\Http\Request;

class PriceTypeController extends Controller
{
    protected $repository;
    public function __construct(PriceTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data = $this->repository->allList();
        return view('admin.price.price-type', compact('data'));
    }

    public function show($id)
    {
        $data = $this->repository->details($id);
        return view('admin.price.pricing', compact('data'));
    }
}
