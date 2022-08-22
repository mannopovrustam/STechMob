<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Http\Controllers\Trade\ClientController;
use App\Services\ClientService\ClientService;
use Livewire\Component;

class SearchClient extends Component
{
    public $searchTerm, $addClient = 'false', $type = 'searchTrade';
    protected $clientService, $clientRepository, $clientRequest;
    public $searchTermData = [], $collections = [];
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function __construct()
    {
        parent::__construct();
        $this->clientService = new ClientService();
    }

    public function mount(ClientServiceInterface $clientService, ClientRepositoryInterface $clientRepository)
    {
        $this->clientService = $clientService;
        $this->clientRepository = $clientRepository;
    }

    public function render()
    {
        return view('livewire.search-client');
    }

    public function clientSearch()
    {
        $filter = [
            'search' => $this->searchTerm,
        ];

        $this->searchTermData = $this->clientRepository->paginate(15,$filter);
    }

    public function addNewClient()
    {
        $data = $this->clientService->createOrUpdate($this->collections);
        $this->addClient = 'false';
    }
}
