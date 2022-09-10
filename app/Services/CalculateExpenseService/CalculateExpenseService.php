<?php

namespace App\Services\CalculateExpenseService;

use App\Contracts\Services\CalculateExpenseInterface;
use App\Models\Expense;
use App\Services\CoreService;

class CalculateExpenseService extends CoreService implements CalculateExpenseInterface
{
    protected $mark;
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Expense::class;
    }

    public function expenseCases($type, $mark, $price)
    {
        switch ($type){
            case Expense::TYPE['total']: return $this->total($mark, $price);
                break;
            case Expense::TYPE['piece']: return $this->piece($mark, $price);
                break;
            case Expense::TYPE['total%']: return $this->percentage($mark, $price);
                break;
            case Expense::TYPE['distribution']: return $this->distribution($mark, $price);
                break;
            default : return 0;
        }
    }

    public function calculateExpense($expense, $mark)
    {
        $checkExpense = 0;
        foreach ($expense as $item){
            $checkExpense = array_key_exists('price', $item);
            if (!$checkExpense){ session()->flash('checkExpense', 'Majburiy maydonlar to\'ldirilishi shart!'); break;}
            $checkExpense = array_key_exists('mark', $item);
            if (!$checkExpense){ session()->flash('checkExpense', 'Majburiy maydonlar to\'ldirilishi shart!'); break;}
        }

        if ($checkExpense && $mark){
            $this->mark = $mark;

            $markExpenses = []; $result = [];
            foreach ($expense as $key => $value){
                $markExpenses[] = $this->expenseCases($value['type'] ?? 1, $value['mark'], $value['price']);
            }
            foreach ($markExpenses as $markExpense) {
                foreach ($markExpense as $key => $item){
                    if (!isset($result[$key])){
                        $result[$key] = $item;
                    }else{
                        $result[$key] += $item;
                    }
                }
            }

            return $result;
        }
    }

    public function total($marks, $price)
    {
        $quantity = [];
        foreach ($marks as $mark){
            if (!array_key_exists($mark, $quantity)){ $quantity[$mark] = 0; }
            $quantity[$mark] += (int)$this->mark[$mark]['quantity'];
        }
        $expense = $price/collect($quantity)->sum();
        foreach ($marks as $mark){
            $quantity[$mark] = $expense*(int)$this->mark[$mark]['quantity'];
        }

        return $quantity;
    }

    public function piece($marks, $price)
    {
        $quantity = [];
        foreach ($marks as $mark){
            $quantity[$mark] = $price*(int)$this->mark[$mark]['quantity'];
        }
        return $quantity;

    }

    public function percentage($marks, $price)
    {
        $quantity = [];
        foreach ($marks as $mark){
            if (!array_key_exists($mark, $quantity)){ $quantity[$mark] = 0; }
            $quantity[$mark] += (int)$this->mark[$mark]['quantity']*(int)$this->mark[$mark]['price']*($price/100);
        }
        return $quantity;
    }

    public function distribution($marks, $price)
    {
        $sumPrice = collect($marks)->map(function ($value){
            return ((double)$this->mark[(int)$value]['price']*(double)$this->mark[(int)$value]['quantity']);
        })->sum();

        $quantity = [];
        foreach ($marks as $mark){
            if (!array_key_exists($mark, $quantity)){ $quantity[$mark] = 0; }

            $percentage = ($this->mark[$mark]['price']*$this->mark[$mark]['quantity'])/$sumPrice;
            $quantity[$mark] += ($percentage*$price);
        }
        return $quantity;
    }

}
