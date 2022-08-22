<?php

namespace App\Http\Controllers\Trade;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $clientRepository;
    private $clientService;
    public function __construct(ClientRepositoryInterface $clientRepository, ClientServiceInterface $clientService)
    {
        $this->clientRepository = $clientRepository;
        $this->clientService = $clientService;
    }

    public function index()
    {
        return view('admin.client.client');
    }

    public function store(Request $request)
    {
        $this->clientService->createOrUpdate($request->all());
    }
}
