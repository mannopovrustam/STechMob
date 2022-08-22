<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        session()->put('warehouse_id', 2);
        $type = Order::TRADE_TYPE_NAME[\request()->get('type')];
        return view('admin.trade.trade', compact('type'));
    }
}
