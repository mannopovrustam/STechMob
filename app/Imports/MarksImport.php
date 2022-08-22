<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Mark;
use App\Models\Type;
use App\Services\ClientService\ClientService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MarksImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $type['id'] = null; $brand['id'] = null;

        $type = Type::firstOrCreate(['name' => $row['turi']]);
        $brand = Brand::firstOrCreate(['name' => $row['brend']]);

        $collection = [$type['id'], $brand['id'], $row['maxsulot'], $row['versiya']];
        (new ClientService())->createOrUpdate($this->setMarkParams($collection));

    }


    private function setMarkParams($collection){
        return [
            'type_id' => $collection[0],
            'brand_id' => $collection[1],
            'name' => $collection[2],
            'version' => $collection[3],
        ];
    }
}
