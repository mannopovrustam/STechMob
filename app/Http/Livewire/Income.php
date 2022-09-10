<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Helpers\ResponseError;
use App\Models\Mark;
use App\Services\CalculateExpenseService\CalculateExpenseService;
use App\Services\ClientService\ClientService;
use App\Traits\Payment;
use Livewire\Component;

class Income extends Component
{
    public $marks = [], $mark;
    public $expense = [], $expenseMarks = [], $expenseInputs = [], $expenseInputsLoop = 1, $expenseResult = [], $expenseResultSum = 0;
    public $addClient = 'false', $addExpense = 'false', $addPay = 'false', $collections = [], $pay = 0, $incomeSum = 0;
    public $addCode = 'false', $addCodeMark, $markCode = [], $code, $discount = 0;
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
        $this->expenseResultSum = collect($this->expenseResult)->sum();

        if ($this->marks){
            $this->incomeSum = collect($this->mark)->map(function ($value, $key){
                return ((isset($value['quantity']) ? (int)$value['quantity'] : 0)*(isset($value['price']) ? (int)$value['price'] : 0));
            })->sum();
        }

        $this->pay = (isset($this->incomeSum) ? $this->incomeSum : 0) + $this->expenseResultSum;

        $this->sumPay($this->pay);

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

    public function addCode($id)
    {
        $this->addCodeMark = $id;
        $this->addCode = 'true';
    }

    public function storeCode($id)
    {
        $mark = Mark::find($id);
        if(!$mark) {
            return ResponseError::ERROR_404;
        }
        $code = session()->get('markCode');

        if (!in_array($this->code, $code[$id])){
            $code[$id][] = $this->code;
        }

        session()->put('markCode', $code);

        $this->code = null;
    }

    public function removeCode($key, $id)
    {
        $code = session()->get('markCode');

        if ($code) {
            unset($code[$key][$id]);
        }

        session()->put('markCode', $code);
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
        $this->expenseResult = $this->calculateExpenseService->calculateExpense($this->expense, $this->mark);
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

    use Payment;
}
