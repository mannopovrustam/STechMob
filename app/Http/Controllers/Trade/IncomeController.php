<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use App\Services\IncomeService\IncomeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class IncomeController extends Controller
{
    protected $service;
    public function __construct(IncomeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.trade.income');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mark.*.code' => 'unique:product_codes',
        ]);

        $data = $this->service->create($request);

        if ($data['status']){
            session()->forget('mark');
            session()->forget('markCode');
        }

        return back();
    }
}
