<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return view('admin.trade.income');
    }

    public function store(Request $request)
    {
        
    }
}
