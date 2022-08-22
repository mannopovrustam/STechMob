<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 11.08.2022
 * Time: 17:51
 */

namespace App\Repositories;


use App\Models\Mark;
use App\Models\Product;
use App\Models\Warehouse;
use Nette\Utils\Arrays;

class CardProductRepository
{
    public function searchTrade($searchTerm)
    {
        $data = [];
        if ($searchTerm && Mark::where('name', 'like', "%{$searchTerm}%")->skip(0)->take(5)->pluck('id')->count() > 0) {
            foreach (Mark::where('name', 'like', "%{$searchTerm}%")->with(['type', 'brand',
                'products' => function($q){ return $q->where('warehouse_id', Warehouse::getId()); },
                'products.shipment' => function($q){ return $q->select('invoice_id'); },
                'products.shipment.invoice' => function($q){ return $q->select('name'); },
            ])->skip(0)->take(5)->get() as $key => $item) {
                $data[] =
                [
                    'id' => $item->id,
                    'type' => $item->type->name ?? null,
                    'brand' => $item->brand->name ?? null,
                    'name' => $item->name,
                    'count' => $item->count,
                    'version' => $item->version,
                ];
            }
        }
        return $data;
    }

    public function searchIncome($searchTerm)
    {
        $data = [];
        if ($searchTerm && Mark::where('name', 'like', "%{$searchTerm}%")->skip(0)->take(5)->pluck('id')->count() > 0) {
            foreach (Mark::where('name', 'like', "%{$searchTerm}%")->with(['type', 'brand',
                'products' => function($q){ $q->select('quantity', 'order_count');}
            ])->skip(0)->take(5)->get() as $key => $item) {
                $data[] = [
                    'id' => $item->id,
                    'type' => $item->type->name ?? null,
                    'brand' => $item->brand->name ?? null,
                    'name' => $item->name,
                    'count' => $item->products->count() > 0 ? $item->products->quantity - $item->products->order_count : 0,
                    'version' => $item->version,
                ];
            }
        }
        return $data;
    }




}