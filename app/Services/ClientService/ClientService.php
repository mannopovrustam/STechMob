<?php

namespace App\Services\ClientService;

use App\Contracts\Services\ClientServiceInterface;
use App\Helpers\FileHelper;
use App\Helpers\ResponseError;
use App\Http\Requests\ClientRequest;
use App\Models\Brand;
use App\Models\Client;
use App\Models\Mark;
use App\Models\User;
use App\Services\CoreService;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientService extends CoreService implements ClientServiceInterface
{
    protected $faker;

    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return User::class;
    }

    public function createOrUpdate($collection)
    {
        try {
            $user = $this->model()->updateOrCreate(['id' => $collection['id'] ?? null], $this->setUserParams($collection));
            $client = Client::updateOrCreate(['user_id' => $user->id], array_merge($this->setClientParams($collection), ['user_id'=>$user->id]));

            if ($user && $client){
                return ['status' => true, 'code' => ResponseError::NO_ERROR];
            }

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

    private function setUserParams($collection){
        return [
            'name' => $collection['name'],
            'phone' => $collection['phone'] ?? Str::random(13),
            'email' => $collection['email'] ?? Str::random(13).'@stechmob.com',
            'password' => Hash::make('client'),
            'role' => User::USER_ROLE['client']
        ];
    }
    private function setClientParams($collection){
        return [
            'code' => $collection['code'] ?? null,
            'region_id' => $collection['region_id'] ?? null,
            'address' => $collection['address'] ?? null,
            'note' => $collection['note'] ?? null,
        ];
    }


}
