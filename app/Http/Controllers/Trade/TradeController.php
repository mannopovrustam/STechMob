<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function show($trade)
    {
        $type = Order::TRADE_TYPE_NAME[$trade];
        return view('admin.trade.trade', compact('type'), compact('trade'));
    }
}
