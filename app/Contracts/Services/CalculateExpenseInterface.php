<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 21.08.2022
 * Time: 22:12
 */

namespace App\Contracts\Services;


interface CalculateExpenseInterface
{
    public function expenseCases($type, $mark, $price);

    public function calculateExpense($expense, $mark);

    public function total($marks, $price);

    public function piece($marks, $price);

    public function percentage($marks, $price);

    public function distribution($marks, $price);
}