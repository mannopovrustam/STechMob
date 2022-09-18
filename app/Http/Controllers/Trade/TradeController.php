<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\TradeService\TradeService;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    protected $tradeService;
    public function __construct(TradeService $tradeService)
    {
        $this->tradeService = $tradeService;
    }

    public function store(Request $request)
    {
        $this->tradeService->create($request);
    }
    public function show($trade)
    {
        $type = Order::TRADE_TYPE_NAME[$trade];
        return view('admin.trade.trade', compact('type'), compact('trade'));
    }
}
