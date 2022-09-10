<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Currency;
use App\Models\Mark;
use App\Models\PriceType;
use App\Models\PriceTypeWarehouse;
use App\Models\Type;
use App\Services\MarkService\MarkService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Pricing implements ToModel, WithHeadingRow
{
    protected $priceType;
    public function __construct($id)
    {
        $this->priceType = $id;
    }

    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $type['id'] = null; $brand['id'] = null;

        $type = Type::firstOrCreate(['name' => $row['turi']]);
        $brand = Brand::firstOrCreate(['name' => $row['brend']]);

        $collection = [$type['id'], $brand['id'], $row['maxsulot'], $row['versiya']];
        (new MarkService())->createOrUpdate($this->setMarkParams($collection));

        $markId = Mark::where('name', $row['maxsulot'])->first()->id;
        PriceTypeWarehouse::updateOrCreate(['price_type_id' => $this->priceType, 'mark_id' => $markId],[
            'price_type_id' => $this->priceType,
            'currency_id' => Currency::whereDefault(1)->first()->id,
            'mark_id' => $markId,
            'bonus' => $row['bonus'] ?? 0,
            'price' => $row['narx'] ?? 0,
        ]);

    }


    private function setMarkParams($collection){
        return [
            'type_id' => $collection[0],
            'brand_id' => $collection[1],
            'name' => $collection[2],
            'version' => $collection[3],
        ];
    }}
