<?php

namespace App\Services\CurrencyService;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Helpers\FileHelper;
use App\Helpers\ResponseError;
use App\Models\Currency;
use App\Services\CoreService;

class CurrencyService extends CoreService implements CurrencyServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Currency::class;
    }

    public function createOrUpdate($collection)
    {
        $first = $this->model()->first();
        if ($first){
            $this->setCurrencyDefault($first);
        }

        try {
            $currency = $this->model()->updateOrCreate($this->setUpdateParams($collection), $this->setDataParams($collection));

            if ($currency){
                // Set Default Currency if this first record on the table/
                $first ?: $this->setCurrencyDefault($currency);

                return ['status' => true, 'code' => ResponseError::NO_ERROR, 'data' => $currency];
            }

            return ['status' => false, 'code' => ResponseError::ERROR_501];

        } catch (\Exception $e) {

            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];

        }
    }

    public function create($collection)
    {
        try {
            $mark = $this->model()->create($this->setDataParams($collection));
            if ($mark) {
                if (isset($collection->images)) {
                    $mark->update(['img' => $collection->images[0]]);
                    $mark->uploads($collection->images);
                }
                return ['status' => true, 'code' => ResponseError::NO_ERROR, 'data' => $mark];
            }
            return ['status' => false, 'code' => ResponseError::ERROR_501];
        } catch (\Exception $e) {
            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];
        }
    }

    public function update($id, $collection)
    {
        try {
            $mark = $this->model()->find($id);
            if ($mark) {
                $mark->update($this->setDataParams($collection));
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
            'rate' => $collection['rate'] ?? 1,
            'title' => $collection['title'],
            'symbol' => $collection['symbol'] ?? null,
            'active' => $collection['active'] ?? 1,
        ];
    }

    private function setUpdateParams($collection){
        return [
            'id' => $collection['id'] ?? null
        ];
    }

    private function setCurrencyDefault($currency){
        $currency->default = 1;
        $currency->active = 1;
        $currency->save();
    }
}
