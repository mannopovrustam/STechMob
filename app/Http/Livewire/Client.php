<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Repositories\ClientRepository;
use App\Services\ClientService\ClientService;
use Livewire\Component;

class Client extends Component
{
    public $collections = [], $addClient = 'false';
    protected $data, $clientService;

    public function __construct()
    {
        parent::__construct();
        $this->clientService = new ClientService();
    }

    public function render(ClientRepositoryInterface $clientRepository, ClientServiceInterface $clientService)
    {
        $this->clientService = $clientService;
        $this->data = $clientRepository->paginate(15);
        return view('livewire.client', ['data' => $this->data]);
    }

    public function editClient($id)
    {
        $user = \App\Models\User::find($id);
        $client = $user->client;
        $this->collections['id'] = $id;
        $this->collections['name'] = $user->name;
        $this->collections['phone'] = $user->phone;
        $this->collections['email'] = $user->email;
        $this->collections['code'] = $client->code ?? null;
        $this->collections['region_id'] = $client->region_id ?? null;
        $this->collections['address'] = $client->address ?? null;
        $this->collections['note'] = $client->note ?? null;

        $this->addClient = 'true';
    }


    public function addNewClient()
    {
        $data = $this->clientService->createOrUpdate($this->collections);
        $this->addClient = 'false';
    }
}
