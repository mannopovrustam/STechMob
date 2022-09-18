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
use App\Services\TradeService\TradeService;
use App\Traits\Payment;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Livewire\Component;

class Trade extends Component
{
    public $marks = [], $mark, $type, $trade;
    public $addClient = 'false', $addPay = 'false', $addDiscount = 'false', $collections, $pay = 0, $cashSum = 0;
    public $getCode = 'false', $getCodeMark, $markCode = [], $code;
    public $shipment = 'false', $shipmentMark, $shipments, $markShipment = [], $shipmentCode = 'false', $shipmentCodes = [];
    public $discount = 0, $discountValue = 0, $discountType = 'money', $client_id, $date;
    public $debt, $payment_term, $payment_term_type, $every_day_month, $monthly_payment;

    protected $data;
    protected $clientService;

    protected $listeners = [
        'refreshCartProductIncome' => 'render',
        'hidePopup' => 'hidePopup',
        'addClient' => 'addClient',
        'addDiscount' => 'addDiscount',
        'addPay' => 'addPay',
    ];

    public function addClient(){$this->addClient = 'true';}
    public function addDiscount(){$this->addDiscount = 'true';}
    public function addPay(){$this->addPay = 'true';}

    public function __construct()
    {
        parent::__construct();
        $this->clientService = new ClientService();
    }

    public function mount($type, $trade)
    {
        $this->type = $type;
        $this->trade = $trade;


        $codes = session()->get('markCode') ?? [];

        foreach ($codes as $mark => $code){
            $productCodeCount = ProductCode::whereIn('id', $code)->with([
                'product' => function($q){$q->whereColumn('quantity', '>', 'order_count');}
            ])->where('order_id', null)->get();

            foreach ($productCodeCount as $value){
                if (!isset($this->mark[$value->product->mark_id]['quantity'])){
                    $this->mark[$value->product->mark_id]['quantity'] = 1;
                }else{
                    $this->mark[$value->product->mark_id]['quantity'] += 1;
                }
                if (!isset($this->markShipment[$value->product->mark_id][$value->shipment_id]['quantity'])){
                    $this->markShipment[$value->product->mark_id][$value->shipment_id]['quantity'] = 1;
                }else{
                    $this->markShipment[$value->product->mark_id][$value->shipment_id]['quantity'] += 1;
                }
            }
        }
    }

    public function render(ClientRepositoryInterface $clientRepository, ClientServiceInterface $clientService)
    {
        $this->clientService = $clientService;
        $this->data = $clientRepository->paginate(15);

        $this->marks = User::getWarehouse()
            ->whereHas('priceType.priceTypeWarehouse', function ($q) {
                $q->whereIn('mark_id', session()->get('mark') ?? []);
            })
            ->with([
                'priceType.priceTypeWarehouse' => function ($q) {
                    $q->whereIn('mark_id', session()->get('mark') ?? []);
                },
                'priceType.priceTypeWarehouse.mark.brand'
            ])->first();

        if ($this->marks) {
            $this->cashSum = collect($this->mark)->map(function ($value, $key) {
                return ((isset($value['quantity']) ? (int)$value['quantity'] : 0) * (isset($value['price']) ? (int)$value['price'] : 0));
            })->sum();
        }

        $this->discount = $this->discountType == 'money' ? $this->discountValue ?? 0 : ($this->discountValue / 100) * $this->cashSum ?? 0;

        $this->pay = ($this->cashSum ?? 0) - ($this->discount ?? 0);
        $this->sumPay($this->pay ?? 0);

        if ($this->trade == 'loan' || $this->trade == 'installment'){
            $this->debt = $this->pay - $this->getSum;
            if ($this->debt && $this->every_day_month){
                $this->monthly_payment = round($this->debt/$this->payment_term, 2);
            }
        }

        $this->markValidate();

        return view('livewire.trade');
    }

    public function hidePopup()
    {
        $this->addClient = 'false';
        $this->addPay = 'false';
        $this->addDiscount = 'false';
        $this->getCode = 'false';
        $this->shipment = 'false';
        $this->shipmentCode = 'false';
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

        $this->shipments = Mark::where('id', $id)->with([
            'products' => function ($q) {
                $q->where('warehouse_id', User::getWarehouse()->id)
                    ->whereColumn('quantity', '>', 'order_count')
                    ->with(['shipment.invoice', 'product_codes']);
            }
        ])->first();

        $marks = Mark::whereIn('id', session()->get('mark'))->with([
            'products' => function ($q) {
                $q->where('warehouse_id', User::getWarehouse()->id)
                ->whereColumn('quantity', '>', 'order_count')->with('shipment');
            }
        ])->get();

        foreach ($marks as $product) {
            foreach ($product->products ?? [] as $key => $value) {
                $this->markShipment[$value->mark_id][$value->shipment->id]['quantity'] = $this->markShipment[$value->mark_id][$value->shipment->id]['quantity'] ?? 0;
            }
        }

    }

    public function shipmentMarkValidate($shipmentMark, $key, $max = null, $min = null)
    {
        $cod = session()->get('markCode') ?? [];

        if (isset($cod[$shipmentMark])) {
            $productCodeCount = ProductCode::whereIn('id', $cod[$shipmentMark])->where([['shipment_id', $key], ['order_id', null]])->count();
        } else {
            $productCodeCount = 0;
        }

        if (($this->markShipment[$shipmentMark][$key]['quantity'] ?? 0) > (double)$max) {
            $this->markShipment[$shipmentMark][$key]['quantity'] = $max;
        }
        if (($this->markShipment[$shipmentMark][$key]['quantity'] ?? 0) < $productCodeCount) {
            $this->markShipment[$shipmentMark][$key]['quantity'] = $productCodeCount;
        }
        if (($this->mark[$shipmentMark]['quantity'] ?? 0) < collect($this->markShipment[$shipmentMark])->sum('quantity')) {
            $this->mark[$shipmentMark]['quantity'] = collect($this->markShipment[$shipmentMark])->sum('quantity');
        };
    }

    public function shipmentCode($shipment)
    {
        $this->shipmentCode = 'true';
        $this->shipmentCodes = $shipment;
    }

    public function getCode($id)
    {
        $this->getCode = 'true';
        $this->getCodeMark = $id;
    }

    public function addCode($code)
    {
        $product = ProductCode::where('id', $code)->with(['product' => function ($q) {
            $q->where([['warehouse_id', User::getWarehouse()->id], ['order_id', null]]);
        }, 'shipment'])->first();

        (new SearchProduct())->addMark($product->product->mark_id);

        $cod = session()->get('markCode') ?? [];

        if (!in_array($code, $cod[$product->product->mark_id] ?? [])) {
            $cod[$product->product->mark_id][$product->id] = $code;
        }

        session()->put('markCode', $cod);

        $productCodeCount = ProductCode::whereIn('id', $cod[$product->product->mark_id])->where('shipment_id', $product->shipment->id)->where('order_id', null)->count();
        $this->shipmentMarkValidate($product->product->mark_id, $product->shipment->id, null, $productCodeCount);

        $this->markValidate();

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

        $product = ProductCode::where('id', $id)->with(['product' => function ($q) {
            $q->where('warehouse_id', User::getWarehouse()->id);
        }, 'shipment'])->where('order_id', null)->first();

        $productCodeCount = ProductCode::whereIn('id', $code[$key])->where('shipment_id', $product->shipment->id)->where('order_id', null)->count();
        $this->shipmentMarkValidate($product->product->mark_id, $product->shipment->id, $productCodeCount);

    }

    use Payment;

    public function markValidate()
    {
        $code = session()->get('markCode');
        if (!empty($this->mark)) {
            foreach ($this->mark as $key => $value) {
                $productMaxCount = collect(Product::where([['mark_id', $key], ['warehouse_id', User::getWarehouse()->id]])
                    ->whereColumn('quantity', '>', 'order_count')->get()->toArray())->map(function ($q){
                    return ($q['quantity'] - $q['order_count']);
                })->sum();

                $productCodeCount = ProductCode::whereIn('id', $code[$key] ?? [])->where('order_id', null)->count();
                if (($this->mark[$key]['quantity'] ?? 0) < $productCodeCount) {
                    $this->mark[$key]['quantity'] = $productCodeCount;
                } else {
                    $this->mark[$key]['quantity'] = $this->mark[$key]['quantity'];
                }
                if ($this->mark[$key]['quantity'] > $productMaxCount) {
                    $this->mark[$key]['quantity'] = $productMaxCount;
                }
            }
        }
    }

    public function storeTrade()
    {

        $marks = Mark::whereIn('id', session()->get('mark'))->with([
            'products' => function ($q) {
                $q->where('warehouse_id', User::getWarehouse()->id)
                ->whereColumn('quantity', '>', 'order_count')->with('shipment');
            }
        ])->get();

        foreach ($marks as $product) {
            foreach ($product->products ?? [] as $key => $value) {
                $this->markShipment[$value->mark_id][$value->shipment->id]['quantity'] =
                    isset($this->markShipment[$value->mark_id][$value->shipment->id]['quantity']) ? $this->markShipment[$value->mark_id][$value->shipment->id]['quantity'] : 0;
                if ($this->markShipment[$value->mark_id][$value->shipment->id]['quantity'] > 0){
                    $this->mark[$value->mark_id][$value->shipment->id]['quantity'] = $this->markShipment[$value->mark_id][$value->shipment->id]['quantity'];
                }
            }
        }

        $this->collections = [
            "trade_type" => \App\Models\Order::TRADE_TYPE[$this->trade],
            "mark" => $this->mark,
            "discount" => $this->discountValue,
            "discountType" => $this->discountType,
            "offer" => $this->offer,
            "currency" => $this->currency,
            "product_codes" => session()->get('markCode'),
            "date" => $this->date,
            "client_id" => $this->client_id,
            "money_sys" => $this->pay,
            "money_get" => $this->getSum,
        ];
        if ($this->trade == 'loan'){
            $loan = [
                'debt' => $this->pay - $this->getSum,
                'payment_term' => $this->payment_term,
                'payment_term_type' => $this->trade == 'installment' ? \App\Models\Order::PAYMENT_TERM_TYPE['month'] : \App\Models\Order::PAYMENT_TERM_TYPE['day']
            ];
            $this->collections = array_merge($this->collections, $loan);
        }
        if ($this->trade == 'installment'){

            $now = Carbon::now();
            if ($now->day < $this->every_day_month){
                $now = $now->subMonth();
            }

            for ($i = 0; $i < $this->payment_term; $i++) {
                $now = Carbon::createFromDate($now->year, $now->month, $this->every_day_month)->addMonth();
                $dates[] = $now->format('d.m.Y');
            }

            $installment = [
                'payment_term' => $this->payment_term,
                'payment_term_type' => $this->trade == 'installment' ? \App\Models\Order::PAYMENT_TERM_TYPE['month'] : \App\Models\Order::PAYMENT_TERM_TYPE['day'],
                'debt' => $this->pay - $this->getSum,
                'every_day_month' => $this->every_day_month,
                'monthly_payment' => $this->monthly_payment,
                'dates' => $dates
            ];
            $this->collections = array_merge($this->collections, $installment);
        }


        $trade = (new TradeService())->create($this->collections);

        dd($trade['message']);
    }

}
