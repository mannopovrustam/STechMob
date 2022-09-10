<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Services\EmployeeServiceInterface;
use App\Models\Currenciable;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Employee extends Component
{
    use WithFileUploads;

    public $addEmployee = 'false', $collection = [];
    private $allEmployees = [];

    public function render(EmployeeRepositoryInterface $repository)
    {
        $this->allEmployees = $repository->paginate(10);
        return view('livewire.employee', ['allEmployees' => $this->allEmployees]);
    }

    public function addEmployee(EmployeeServiceInterface $service)
    {
        $this->collection['role'] = \App\Models\User::USER_ROLE['employee'];

        if (isset($this->collection['second_currency'])){
            foreach ($this->collection['second_currency'] as $key => $value){
                if ($this->collection['second_currency'][$key] == false){
                    unset($this->collection['second_currency'][$key]);
                }
            }
        }

        $status = $service->createOrUpdate($this->collection);
        if (isset($status['message'])){
            session()->flash('checkEmployee', $status['message']);
        }else{
            session()->flash('checkEmployee', $status['code']);
        }
    }

    public function currencyChange()
    {
        unset($this->collection['second_currency']);
    }

    public function editEmployee($array)
    {
        $this->collection['id'] = $array['id'];
        $this->collection['name'] = $array['name'];
        $this->collection['phone'] = $array['phone'];
        $this->collection['email'] = $array['email'];
        $this->collection['rent'] = $array['employee']['rent'];
        $this->collection['profit'] = $array['employee']['profit'];
        $this->collection['salary'] = $array['employee']['salary'];
        $this->collection['salary_date'] = $array['employee']['salary_date'];
        $this->collection['bonus'] = $array['employee']['bonus'];
        $this->collection['currency'] = $array['main_currency'][0]['id'];
        foreach ($array['second_currency'] as $key => $item) {
            $this->collection['second_currency'][$key] = $item['id'];
        }
        $this->addEmployee = 'true';
    }
}
