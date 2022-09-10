<div class="popup__add width__25 {{ $shipment }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card" xmlns:wire="http://www.w3.org/1999/xhtml">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Yuk <span
                        style="font-size: small; color: #ccc">{{ \App\Models\Mark::find($shipmentMark)?->name }}</span>
            </h5>
            <a href="javascript:void(0);" wire:click="$set('shipment', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <div class="card-body p-4 row">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>Yuk</th>
                        <th class="text-end">Soni
                            ({{ isset($markShipment[$shipmentMark]) ? collect($markShipment[$shipmentMark])->sum('quantity') : 0}}
                            )
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shipments->products ?? [] as $key => $value)
                        <tr>
                            <td>
                                <b>{{ $value->shipment->invoice->name }}</b> ({{ $value->quantity }})
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$value->shipment->invoice->date)->format('d.m.Y') }}

                                @if($value->product_codes->count() > 0)
                                    <button class="btn-sm btn-success" type="button"
                                            wire:click="shipmentCode({{$value}})">
                                        <i class="fa fa-barcode"></i>
                                    </button>
                                @endif
                            </td>
                            <td class="text-end">
                                <input type="text" class="form-control"
                                       wire:model="markShipment.{{$shipmentMark}}.{{$value->shipment->id}}.quantity"
                                       wire:change="shipmentMarkValidate('{{$shipmentMark}}', '{{$value->shipment->id}}', '{{$value->quantity}}')"
                                >
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <div class="popup__add width__25 {{$shipmentCode}}" xmlns:wire="http://www.w3.org/1999/xhtml">
            <div class="card" xmlns:wire="http://www.w3.org/1999/xhtml">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">Invoice <span style="font-size: small; color: #ccc">{{ $shipmentCodes ? $shipmentCodes['shipment']['invoice']['name'] : ''}}</span></h5>
                    <a href="javascript:void(0);" wire:click="$set('shipmentCode', 'false')" class="ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>IMEI</th>
                                <th class="text-end"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($shipmentCodes ? $shipmentCodes['product_codes'] : [] as $code)
                                <tr class="bg-light">
                                    <td>
                                        {{ $code['code'] }}
                                    </td>
                                    <td class="text-end">
                                        @if(in_array($code['id'], session()->get('markCode')[$shipmentMark] ?? []))
                                            <button type="button"
                                                    class="order btn-sm btn-danger"
                                                wire:click="removeCode({{$shipmentMark}},{{$code['id']}})">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="order btn-sm btn-success"
                                                    wire:click="addCode({{$code['id']}})">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
</div>