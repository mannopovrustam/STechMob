<?php

namespace App\Http\Livewire;

use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Models\Mark;
use App\Models\Product;
use App\Models\ProductCode;
use App\Models\Shipment;
use App\Models\User;
use App\Services\ClientService\ClientService;
use App\Traits\Payment;
use Livewire\Component;

class Transfer extends Component
{
    public $marks = [], $mark, $type, $trade;
    public $addClient = 'false', $addPay = 'false', $addDiscount = 'false', $collections = [], $pay = 0, $cashSum = 0;
    public $getCode = 'false', $getCodeMark, $markCode = [], $code;
    public $shipment = 'false', $shipmentMark, $shipments, $markShipment, $shipmentCode = 'false', $shipmentCodes = [];
    public $discount = 0, $discountValue = 0, $discountType = 'money';

    protected $data;
    protected $clientService;

    protected $listeners = ['refreshCartProductIncome' => 'render'];

    public function __construct()
    {
        parent::__construct();
        $this->clientService = new ClientService();
    }

    public function render()
    {
        $this->marks = User::getWarehouse()
            ->whereHas('priceType.priceTypeWarehouse', function ($q) { $q->whereIn('mark_id', session()->get('mark') ?? []);})
            ->with([
                'priceType.priceTypeWarehouse' => function ($q) { $q->whereIn('mark_id', session()->get('mark') ?? []);},
                'priceType.priceTypeWarehouse.mark.brand'
            ])->first();

        if ($this->marks){
            $this->cashSum = collect($this->mark)->map(function ($value, $key){
                return ((isset($value['quantity']) ? (int)$value['quantity'] : 0)*(isset($value['price']) ? (int)$value['price'] : 0));
            })->sum();
        }

        $this->discount = $this->discountType == 'money' ? $this->discountValue : ($this->discountValue/100)*$this->cashSum;

        $this->pay = $this->cashSum - $this->discount;
        $this->sumPay($this->pay);

        $this->markValidate();

        return view('livewire.transfer');
    }

    public function removeMark($id)
    {
        $mark = session()->get('mark');
        if ($mark[$id]) {
            unset($mark[$id]);
        }
        session()->put('mark', $mark);
    }

    public function addNewClient()
    {
        $this->clientService->createOrUpdate($this->collections);
        $this->addClient = 'false';
    }

    public function shipment($id)
    {
        $this->shipment = 'true';
        $this->shipmentMark = $id;

        $this->shipments = Mark::where('id',$id)->with([
            'products' => function($q){
                $q->where('warehouse_id', User::getWarehouse()->id);
                $q->where('quantity', '!=', 'order_count');
            },
            'products.shipment.invoice', 'products.product_codes'
        ])->first();
    }

    public function shipmentMarkValidate($shipmentMark, $key, $max = null, $min = null)
    {
        $cod = session()->get('markCode') ?? [];

        if (isset($cod[$shipmentMark])){
            $productCodeCount = ProductCode::whereIn('id',$cod[$shipmentMark])->where('shipment_id', $key)->count();
        }else{
            $productCodeCount = 0;
        }

        if (($this->markShipment[$shipmentMark][$key]['quantity'] ?? 0) > (double)$max){
            $this->markShipment[$shipmentMark][$key]['quantity'] = $max;
        }
        if (($this->markShipment[$shipmentMark][$key]['quantity'] ?? 0) < $productCodeCount){
            $this->markShipment[$shipmentMark][$key]['quantity'] = $productCodeCount;
        }
        if (($this->mark[$shipmentMark]['quantity'] ?? 0) < collect($this->markShipment[$shipmentMark])->sum('quantity')){
            $this->mark[$shipmentMark]['quantity'] = collect($this->markShipment[$shipmentMark])->sum('quantity');
        };
    }

    public function shipmentCode($shipment)
    {
        $this->shipmentCode = 'true';
        $this->shipmentCodes = collect($shipment);
    }

    public function getCode($id)
    {
        $this->getCode = 'true';
        $this->getCodeMark = $id;
    }

    public function addCode($code)
    {
        $product = ProductCode::where('id',$code)->with(['product' => function($q){
            $q->where('warehouse_id', User::getWarehouse()->id);
        }, 'shipment'])->first();

        (new SearchProduct())->addMark($product->product->mark_id);


        $cod = session()->get('markCode') ?? [];


        if (!in_array($code, $cod[$product->product->mark_id] ?? [])){
            $cod[$product->product->mark_id][$product->id] = $code;
        }

        session()->put('markCode', $cod);

        $this->markValidate();

        $productCodeCount = ProductCode::whereIn('id',$cod[$product->product->mark_id])->where('shipment_id', $product->shipment->id)->count();
        $this->shipmentMarkValidate($product->product->mark_id, $product->shipment->id, null, $productCodeCount);

        $this->searchTerm = null;
    }


    public function removeCode($key, $id)
    {
        $code = session()->get('markCode');
        if ($code) {
            unset($code[$key][$id]);
        }

        session()->put('markCode', $code);
        $this->markValidate();

        $product = ProductCode::where('id',$id)->with(['product' => function($q){
            $q->where('warehouse_id', User::getWarehouse()->id);
        }, 'shipment'])->first();

        $productCodeCount = ProductCode::whereIn('id',$code[$key])->where('shipment_id', $product->shipment->id)->count();
        $this->shipmentMarkValidate($product->product->mark_id, $product->shipment->id, $productCodeCount);

    }
    use Payment;

    public function markValidate()
    {
        $code = session()->get('markCode');
        if (!empty($this->mark)){
            foreach ($this->mark as $key => $value){
                $productMaxCount = collect(Product::where([['mark_id', $key], ['warehouse_id', User::getWarehouse()->id], ['quantity' ,'!=','order_count']])->get()->toArray())->sum('quantity');
                $productCodeCount = ProductCode::whereIn('id',$code[$key] ?? [])->count();
                if (($this->mark[$key]['quantity'] ?? 0) < $productCodeCount){
                    $this->mark[$key]['quantity'] = $productCodeCount;
                }else{
                    $this->mark[$key]['quantity'] = $this->mark[$key]['quantity'];
                }
                if ($this->mark[$key]['quantity'] > $productMaxCount){
                    $this->mark[$key]['quantity'] = $productMaxCount;
                }
            }
        }
    }

}
