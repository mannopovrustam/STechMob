<?php

namespace App\Services\EmployeeService;

use App\Contracts\Services\EmployeeServiceInterface;
use App\Contracts\Services\WarehouseServiceInterface;
use App\Helpers\FileHelper;
use App\Helpers\ResponseError;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\CoreService;
use Illuminate\Support\Facades\Hash;

class EmployeeService extends CoreService implements EmployeeServiceInterface
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
            $employee = Employee::updateOrCreate(['user_id' => $user->id], array_merge($this->setEmployeeParams($collection), ['user_id'=>$user->id]));

            if ($employee){
                if (isset($collection['photo'])){
                    $path = $collection['photo']->store('public/images');
                    $employee->update(['photo' => $path]);
                }
                $user->currencies()->syncWithPivotValues([$collection['currency']], ['default'=>true]);
                if (isset($collection['second_currency'])){
                    $user->currencies()->syncWithoutDetaching($collection['second_currency'], ['default'=>false]);
                }else{
                    $user->currencies()->where('default', false)->delete();
                }
            }

            if ($user && $employee){
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
            'password' => Hash::make('employee'),
            'role' => User::USER_ROLE['employee']
        ];
    }

    private function setEmployeeParams($collection){
        return [
            'rent' => $collection['rent'] ?? 0,
            'profit' => $collection['profit'] ?? 0,
            'salary' => $collection['salary'] ?? 0,
            'salary_date' => $collection['salary_date'] ?? 25,
            'bonus' => $collection['bonus'] ?? false,
        ];
    }


}
