<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 11.08.2022
 * Time: 17:24
 */

namespace App\Services\IncomeService;


use App\Helpers\ResponseError;
use App\Models\Invoice;
use App\Models\MoneyInvoice;
use App\Models\Product;
use App\Models\ProductExpense;
use App\Models\Transferable;
use App\Models\User;
use App\Services\CoreService;
use Illuminate\Support\Facades\DB;

class IncomeService extends CoreService
{
    protected function getModelClass()
    {
        return Product::class;
    }

    public function create($collection)
    {
        try {
            DB::transaction(function () use ($collection) {

                $quantity = collect($collection['mark'])->map(function ($q) {
                    return (int)$q['quantity'] ?? 0;
                })->sum();

                $lastInvoice = isset(Invoice::orderBy('created_at', 'desc')->first()->name) ? Invoice::orderBy('created_at', 'desc')->first()->name : 'AA-0000000';

                $invoice = Invoice::create([
                    'name' => (new Invoice())->generateInvoice($lastInvoice),
                    'date' => $collection['date']
                ]);

                $shipment = $invoice->shipments()->create([
                    'client_id' => $collection['client_id'],
                    'warehouse_id' => User::getWarehouse()->id,
                    'user_id' => auth()->id(),
                    'quantity' => $quantity,
                ]);

                foreach ($collection['mark'] as $key => $value) {
                    $product = $shipment->products()->create([
                        'mark_id' => $key,
                        'warehouse_id' => User::getWarehouse()->id,
                        'quantity' => $value['quantity'],
                        'note' => $value['note'],
                        'price' => $value['price'],
                        'expense' => $value['expense'],
                    ]);


                    if (isset($value['code'])) {
                        foreach ($value['code'] as $value){
                            $product->product_codes()->create([
                                'code' => $value,
                                'order_id' => $product->order->id ?? null,
                                'shipment_id' => $product->shipment->id ?? null,
                                'status' => null
                            ]);
                        }
                    }

                }


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
                }

                Transferable::create([
                    'user_id' => auth()->id(),
                    'warehouse_id' => User::getWarehouse()->id,
                    'type' => Transferable::TYPE['receiver'],
                    'transferable_type' => $moneyTransfer,
                    'transferable_id' => $moneyTransfer->id,
                    'date' => $collection['date'],
                    'note' => User::getCurrency()->map(function ($q) {
                        return $q->title . ":" . $q->rate;
                    })->implode('; '),
                    'status' => Transferable::STATUS['success']
                ]);

                Transferable::create([
                    'user_id' => $collection['client_id'],
                    'type' => Transferable::TYPE['sender'],
                    'transferable_type' => $moneyTransfer,
                    'transferable_id' => $moneyTransfer->id,
                    'date' => $collection['date'],
                    'note' => User::getCurrency()->map(function ($q) {
                        return $q->title . ":" . $q->rate;
                    })->implode('; '),
                    'status' => Transferable::STATUS['success']
                ]);

                if (isset($collection['expense'])) {
                    foreach ($collection['expense'] as $key => $value) {
                        $invoice->product_expenses()->create([
                            'name' => $value->name,
                            'price' => $value->price,
                            'type' => $value->type,
                            'note' => User::getWarehouse()->first()->title . ":" . User::getWarehouse()->first()->rate . ";" . $value->note,
                            'mark' => collect($value->mark)->toJson(),
                            'user_id' => $value->user_id ?? User::where('role', 1)->first()->id,
                        ]);

                        if ($value->user_id != auth()->id()){
                            $lastMoneyInvoice = isset(MoneyInvoice::orderBy('created_at', 'desc')->first()->name) ? MoneyInvoice::orderBy('created_at', 'desc')->first()->name : 'AA-0000000';
                            $moneyInvoice = $invoice->money_invoices()->create([
                                'name' => (new Invoice())->generateInvoice($lastMoneyInvoice),
                                'currency_id' => User::getCurrency()->first()->id,
                                'money_sys' => $value->price,
                                'money_get' => $value->price,
                            ]);

                            $moneyTransfer = $moneyInvoice->money_transfers()->create([
                                'currency_id' => User::getCurrency()->first()->id,
                                'money_sys' => $value->price,
                                'money_get' => $value->price,
                                'main' => true,
                            ]);

                            Transferable::create([
                                'user_id' => auth()->id(),
                                'warehouse_id' => User::getWarehouse()->id,
                                'type' => Transferable::TYPE['sender'],
                                'transferable_type' => $moneyTransfer,
                                'transferable_id' => $moneyTransfer->id,
                                'date' => $collection['date'],
                                'note' => User::getCurrency()->first()->rate,
                                'status' => Transferable::STATUS['must']
                            ]);

                            Transferable::create([
                                'user_id' => auth()->id(),
                                'warehouse_id' => User::getWarehouse()->id,
                                'type' => Transferable::TYPE['receiver'],
                                'transferable_type' => $moneyTransfer,
                                'transferable_id' => $moneyTransfer->id,
                                'date' => $collection['date'],
                                'note' => User::getCurrency()->first()->rate,
                                'status' => Transferable::STATUS['must']
                            ]);
                        }
                    }
                }

            });
            return ['status' => true, 'code' => ResponseError::NO_ERROR];
        } catch (\Exception $e) {
            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];
        }
    }

}