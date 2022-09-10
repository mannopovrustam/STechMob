<?php

namespace App\Services\PriceTypeService;

use App\Contracts\Services\PriceTypeServiceInterface;
use App\Helpers\FileHelper;
use App\Helpers\ResponseError;
use App\Models\Currency;
use App\Models\PriceType;
use App\Services\CoreService;

class PriceTypeService extends CoreService implements PriceTypeServiceInterface
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

    public function create($collection)
    {
        try {
            $mark = $this->model()->create($this->setPriceTypeParams($collection));
            return ['status' => true, 'code' => ResponseError::NO_ERROR, 'data' => $mark];
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
