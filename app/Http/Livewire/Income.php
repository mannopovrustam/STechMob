<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Models\Mark;
use App\Services\CalculateExpenseService\CalculateExpenseService;
use App\Services\ClientService\ClientService;
use Livewire\Component;

class Income extends Component
{
    public $marks = [], $mark;
    public $expense = [], $expenseMarks = [], $expenseInputs = [], $expenseInputsLoop = 1;
    public $addClient = 'false', $addExpense = 'false', $addPay = 'false', $collections = [];
    protected $data;
    protected $clientService, $calculateExpenseService;

    protected $listeners = ['refreshCartProductIncome' => 'render'];

    public function __construct()
    {
        parent::__construct();
        $this->clientService = new ClientService();
        $this->calculateExpenseService = new CalculateExpenseService();
    }

    public function render(ClientRepositoryInterface $clientRepository, ClientServiceInterface $clientService)
    {
        $this->clientService = $clientService;
        $this->data = $clientRepository->paginate(15);
        $this->marks = Mark::whereIn('id', session()->get('mark') ?? [])->get();
        return view('livewire.income');
    }

    public function removeMark($id)
    {
        $mark = session()->get('mark');
        if ($mark[$id]) {
            unset($mark[$id]);
        }
        session()->put('mark', $mark);
    }

    public function addNewClient()
    {
        $this->clientService->createOrUpdate($this->collections);
        $this->addClient = 'false';
    }

    public function expenseMark($key)
    {
        return $expenseMarks[$key] = 'false';
    }

    public function marks()
    {
        return Mark::whereIn('id', session()->get('mark') ?? [])->get();
    }

    public function calculateExpense(){
        return $this->calculateExpenseService->calculateExpense($this->expense, $this->mark);
    }

    public function addExpense($expenseInputsLoop)
    {
        $this->expenseInputsLoop = $expenseInputsLoop + 1;
        $this->expenseInputs[(int)$this->expenseInputsLoop] = $this->expenseInputsLoop;
    }

    public function removeExpense($expenseInputsLoop)
    {
        unset($this->expenseInputs[$expenseInputsLoop]);
        unset($this->expense[$expenseInputsLoop]);
    }
}
