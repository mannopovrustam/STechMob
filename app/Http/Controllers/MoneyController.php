<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoneyController extends Controller
{
    public function transfer(){
        return view('admin.money.transfer.transfer');
    }
    public function transferStore(){}
    public function balance(){}
    public function exchange(){}
    public function report(){}
}
