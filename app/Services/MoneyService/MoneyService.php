<?php

namespace App\Services\MoneyService;

use App\Helpers\FileHelper;
use App\Helpers\ResponseError;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\MoneyInvoice;
use App\Models\MoneyTransfer;
use App\Models\PriceType;
use App\Models\Transferable;
use App\Models\User;
use App\Services\CoreService;

class MoneyService extends CoreService
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return PriceType::class;
    }

    public function createOrUpdate($collection)
    {
        try {
            $priceType = $this->model()->updateOrCreate(['id' => $collection['id'] ?? null], $this->setDataParams($collection));

            return ['status' => false, 'code' => ResponseError::NO_ERROR, 'data' => $priceType];
        } catch (\Exception $e) {
            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];
        }
    }

    public function transfer($collection)
    {
        try {

            $lastMoneyInvoice = isset(MoneyInvoice::orderBy('created_at', 'desc')->first()->name) ? MoneyInvoice::orderBy('created_at', 'desc')->first()->name : 'AA-0000000';

            $moneyInvoice = MoneyInvoice::create([
                'name' => (new Invoice())->generateInvoice($lastMoneyInvoice),
                'currency_id' => User::getCurrency()->first()->id,
                'money_sys' => $collection['sum'],
                'money_get' => $collection['sum'],
            ]);

            $moneyTransfer = $moneyInvoice->money_transfers()->create([
                'currency_id' => $collection['currency_id'],
                'money_sys' => $collection['sum'],
                'money_get' => $collection['sum'],
                'main' => $collection['currency_id'],
                'status' => Transferable::STATUS['waiting'],
            ]);

            Transferable::create([
                'user_id' => auth()->id(),
                'warehouse_id' => User::getWarehouse()->id,
                'type' => Transferable::TYPE['sender'],
                'transferable_type' => MoneyTransfer::class,
                'transferable_id' => $moneyTransfer->id,
                'date' => $collection['date'],
                'note' => User::getCurrency()->map(function ($q) {
                    return $q->title . ":" . $q->rate;
                })->implode('; '),
                'status' => Transferable::STATUS['success']
            ]);

            Transferable::create([
                'user_id' => null,
                'warehouse_id' => $collection['warehouse_id'],
                'type' => Transferable::TYPE['receiver'],
                'transferable_type' => MoneyTransfer::class,
                'transferable_id' => $moneyTransfer->id,
                'date' => $collection['date'],
                'note' => User::getCurrency()->map(function ($q) {
                    return $q->title . ":" . $q->rate;
                })->implode('; '),
                'status' => Transferable::STATUS['waiting']
            ]);

            return ['status' => true, 'code' => ResponseError::NO_ERROR];
        } catch (\Exception $e) {
            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];
        }
    }

    public function update($id, $collection)
    {
        try {
            $mark = $this->model()->find($id);
            if ($mark) {
                $mark->update($this->setPriceTypeParams($collection));
                if ($collection->img) {
                    $img = FileHelper::uploadFile($collection->img, 'images/brands/');
                    $mark->update(['img' => $img]);
                }
                return ['status' => true, 'code' => ResponseError::NO_ERROR, 'data' => $mark];
            }
            return ['status' => false, 'code' => ResponseError::ERROR_404];
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

    private function setDataParams($collection){
        return [
            'id' => $collection['id'] ?? null,
            'name' => $collection['name']
        ];
    }


}
