<?php

namespace App\Services\MarkService;

use App\Contracts\Services\MarkServiceInterface;
use App\Helpers\FileHelper;
use App\Helpers\ResponseError;
use App\Models\Mark;
use App\Services\CoreService;

class MarkService extends CoreService implements MarkServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Mark::class;
    }

    public function createOrUpdate($collection)
    {
        try {
            $this->model()->upsert($this->setMarkParams($collection), array_keys($collection));
            return ['status' => false, 'code' => ResponseError::ERROR_501];
        } catch (\Exception $e) {
            return ['status' => false, 'code' => ResponseError::ERROR_400, 'message' => $e->getMessage()];
        }
    }

    public function create($collection)
    {
        try {
            $mark = $this->model()->create($this->setMarkParams($collection));
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
                $mark->update($this->setMarkParams($collection));
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

    private function setMarkParams($collection){
        return [
            'type_id' => $collection['type_id'] ?? null,
            'brand_id' => $collection['brand_id'] ?? null,
            'name' => $collection['name'],
            'version' => $collection['version'] ?? null,
        ];
    }


}
