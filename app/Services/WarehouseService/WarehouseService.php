<?php

namespace App\Services\WarehouseService;

use App\Contracts\Services\WarehouseServiceInterface;
use App\Helpers\FileHelper;
use App\Helpers\ResponseError;
use App\Models\Currency;
use App\Models\PriceType;
use App\Models\Warehouse;
use App\Services\CoreService;

class WarehouseService extends CoreService implements WarehouseServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Warehouse::class;
    }

    public function createOrUpdate($collection)
    {
        try {
            $warehouse = $this->model()->updateOrCreate(['id' => $collection['id'] ?? null], $this->setDataParams($collection));
            if ($warehouse && Currency::exists()){
                $warehouse->currencies()->syncWithPivotValues([$collection['currency']], ['default'=>true]);
                if (isset($collection['second_currency'])){
                    $warehouse->currencies()->syncWithoutDetaching($collection['second_currency'], ['default'=>false]);
                }else{
                    $warehouse->currencies()->where('default', false)->delete();
                }
                return ['status' => false, 'code' => ResponseError::NO_ERROR];
            }
            return ['status' => false, 'code' => ResponseError::NO_ERROR, 'data' => $warehouse];
        } catch (\Exception $e) {
            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];
        }
    }

    public function create($collection)
    {
        try {
            $mark = $this->model()->create($this->setWarehouseParams($collection));
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
                $mark->update($this->setWarehouseParams($collection));
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
            'name' => $collection['name'],
            'address' => $collection['address'] ?? null,
            'default' => $collection['default'] ?? 0,
            'price_type_id' => $collection['price_type_id'] ?? PriceType::first()->id,
        ];
    }


}
