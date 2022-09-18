<?php

namespace App\Services\TradeService;

use App\Helpers\FileHelper;
use App\Helpers\ResponseError;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\MoneyInvoice;
use App\Models\MoneyTransfer;
use App\Models\Order;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\Transferable;
use App\Models\User;
use App\Services\CoreService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TradeService extends CoreService
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Invoice::class;
    }

    public function create($collection)
    {
        try {

            DB::transaction(function () use ($collection) {

                $lastInvoice = isset($this->model()->orderBy('created_at', 'desc')->first()->name) ? $this->model()->orderBy('created_at', 'desc')->first()->name : 'AA-0000000';

                $invoice = $this->model()->create([
                    'name' => (new Invoice())->generateInvoice($lastInvoice),
                    'date' => $collection['date']
                ]);

                $this->order($invoice, $collection);

                $this->orderPayment($invoice, $collection);

            });

            return ['status' => true, 'code' => ResponseError::NO_ERROR, 'message' => 'Good!!'];
        } catch (\Exception $e) {
            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];
        }
    }

    public function update($id, $collection)
    {
        try {
            return ['status' => true, 'code' => ResponseError::NO_ERROR];
        } catch (\Exception $e) {
            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];
        }
    }

    public function delete(int $id)
    {
        $item = $this->model()->find($id);
        if ($item) {
            FileHelper::deleteFile($item->img);
            $item->delete();
            return ['status' => true, 'code' => ResponseError::NO_ERROR];
        }
        return ['status' => false, 'code' => ResponseError::ERROR_404];
    }

    public function order($invoice, $collection)
    {
        $order = $invoice->orders()->create([
            'warehouse_id' => User::getWarehouse()->id,
            'client_id' => $collection['client_id'],
            'user_id' => auth()->id(),
            'trade_type' => $collection['trade_type'],
        ]);

        foreach ($collection['mark'] as $mark => $shipments) {
            foreach ($shipments as $shipment => $value) {
                $products = Product::where([
                    ['mark_id', $mark],
                    ['shipment_id', $shipment],
                    ['warehouse_id', User::getWarehouse()->id]
                ])->whereColumn('quantity', '>', 'order_count')
                    ->orderBy('created_at')->with([
                    'product_codes' => function ($q) {
                        return $q->where('order_id', null)->orderBy('created_at');
                    }
                ])->get();
                foreach ($products as $product) {
                    $difference = $product->quantity - $product->order_count;
                    if ($value['quantity'] <= $difference){
                        $product->order_count = ($product->order_count + $value['quantity']);
                        $product->save();
                        $this->orderDetail($order, $products, $value, $shipments, $collection);
                        break;
                    }elseif ($value['quantity'] > $difference){
                        $product->order_count = ($product->order_count + $difference);
                        $product->save();
                        $value['quantity'] = $value['quantity'] - $difference;
                    }
                    if ($value['quantity'] > ($difference - $product->product_codes->count())) {
                        foreach ($product->product_codes as $code) {
                            $code->order_id = $order->id;
                            $code->save();
                        }
                    }
                    $this->orderDetail($order, $products, $value, $shipments, $collection);
                }
            }
            $shipmentsValue = Arr::except($shipments, ['quantity', 'price']);
            if ($shipments['quantity'] > collect($shipmentsValue)->sum('quantity')){
                $products = Product::where([
                    ['mark_id', $mark],
                    ['warehouse_id', User::getWarehouse()->id]
                ])->whereColumn('quantity', '>', 'order_count')
                ->with(['product_codes' => function($q){$q->where('order_id', null);}])->orderBy('created_at')->get();

                foreach ($products as $product){
                    $difference = $product->quantity - $product->order_count;
                    if ($shipments['quantity'] <= $difference){
                        $product->order_count = ($product->order_count + $shipments['quantity']);
                        $product->save();
                        $this->orderDetail($order, $product, $shipments, $shipments, $collection);
                        break;
                    }elseif ($shipments['quantity'] > $difference){
                        $product->order_count = ($product->order_count + $difference);
                        $product->save();
                        $shipments['quantity'] = $shipments['quantity'] - $difference;
                    }

                    if ($shipments['quantity'] > ($difference - $product->product_codes->count())){
                        foreach ($product->product_codes->take($shipments['quantity'] - $difference + $product->product_codes->count()) as $code){
                            $code->order_id = $order->id;
                            $code->save();
                        }
                    }
                    $this->orderDetail($order, $product, $shipments, $shipments, $collection);
                }
            }
        }
    }

    public function orderPayment($invoice, $collection)
    {

        $lastMoneyInvoice = isset(MoneyInvoice::orderBy('created_at', 'desc')->first()->name) ? MoneyInvoice::orderBy('created_at', 'desc')->first()->name : 'AA-0000000';

        $moneyInvoice = $invoice->money_invoices()->create([
            'name' => (new Invoice())->generateInvoice($lastMoneyInvoice),
            'currency_id' => User::getCurrency()->first()->id,
            'money_sys' => $collection['money_sys'],
            'money_get' => $collection['money_get'],
        ]);

        foreach (collect($collection['currency'])->whereNotNull() as $key => $value) {
            $moneyTransfer = $moneyInvoice->money_transfers()->create([
                'currency_id' => $key,
                'money_sys' => $key == User::getCurrency()->first()->id ? $collection['offer'][$key] : 0,
                'money_get' => $value,
                'main' => $key == User::getCurrency()->first()->id ? true : false,
                'status' => Transferable::STATUS['success'],
            ]);

            Transferable::create([
                'user_id' => auth()->id(),
                'warehouse_id' => User::getWarehouse()->id,
                'type' => Transferable::TYPE['receiver'],
                'transferable_type' => MoneyTransfer::class,
                'transferable_id' => $moneyTransfer->id,
                'date' => $collection['date'],
                'note' => User::getCurrency()->map(function ($q) {
                    return $q->title . ":" . $q->rate;
                })->implode('; '),
                'status' => Transferable::STATUS['must']
            ]);

            Transferable::create([
                'user_id' => $collection['client_id'],
                'type' => Transferable::TYPE['sender'],
                'transferable_type' => MoneyTransfer::class,
                'transferable_id' => $moneyTransfer->id,
                'date' => $collection['date'],
                'note' => User::getCurrency()->map(function ($q) {
                    return $q->title . ":" . $q->rate;
                })->implode('; '),
                'status' => Transferable::STATUS['must']
            ]);
        }

    }

    public function orderDetail($order, $product, $value, $shipments, $collection)
    {
        $orderProduct = $order->products()->create([
            'product_id' => $product->id,
            'quantity' => $value['quantity'],
            'price' => $shipments['price'],
        ]);
        if ($order->trade_type == Order::TRADE_TYPE['loan'] || $order->trade_type == Order::TRADE_TYPE['installment']) {
            $orderProductDetail = $orderProduct->details()->create([
                'debt' => $collection['debt'],
                'payment_term' => $collection['payment_term'],
                'payment_term_type' => $collection['payment_term_type'],
                'every_day_month' => $collection['every_day_month'] ?? null,
                'monthly_payment' => $collection['monthly_payment'] ?? null,
            ]);
            if ($order->trade_type == Order::TRADE_TYPE['installment']) {
                for ($i = 0; $i < count($collection['dates']); $i++){
                    $orderProductDetail->installment_detail()->create([
                        'debt' => $collection['monthly_payment'],
                        'payment_date' => $collection['dates'][$i],
                    ]);
                }
            }
        }
    }

    private function setDataParams($collection)
    {
        return [
            'name' => $collection['name'],
            'address' => $collection['address'] ?? null,
            'default' => $collection['default'] ?? 0,
            'price_type_id' => $collection['price_type_id'] ?? PriceType::first()->id,
        ];
    }


}
