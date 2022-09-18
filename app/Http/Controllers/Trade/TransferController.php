<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function __invoke()
    {
        $trade = 'transfer';
        $type = Order::TRADE_TYPE_NAME[$trade];
        return view('admin.trade.transfer', compact('type'), compact('trade'));
    }
}
