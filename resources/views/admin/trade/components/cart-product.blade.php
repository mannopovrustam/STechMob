<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <table id="datatable" class="table table-bordered dt-responsive nowrap"
           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
        <tr>
            <th>#</th>
            <th>Brend</th>
            <th>Model</th>
            <th>Soni</th>
            <th>Taklifdagi narx</th>
            <th>Narx ({{ $this->cashSum }})</th>
            <th>Mahsulot (23)</th>
        </tr>
        </thead>
        <tbody>
        @isset($marks->priceType->priceTypeWarehouse)
            @foreach($marks->priceType->priceTypeWarehouse as $key => $value)
                <tr>
                    <td>
                        <button class="btn-sm btn-danger" type="button"
                                wire:click="removeMark({{$value->mark_id ?? false}})"><i class="fa fa-minus"></i>
                        </button>
                    </td>
                    <td>{{ $value->mark->brand->name }}</td>
                    <td>{{ $value->mark->name }} {{ $value->mark->versiya }}</td>
                    <td class="d-flex justify-content-between align-items-center">
                        <input type="text" class="form-control form-control-sm"
                               name="mark[{{ $value->mark_id }}][quantity]"
                               wire:model="mark.{{ $value->mark_id }}.quantity"
                               wire:change="markValidate()"
                               value="{{ $mark[$value->mark_id]['quantity'] ?? 0 }}"
                               style="margin-right: 1rem;" autocomplete="off">
                        <a href="javascript:void(0);" wire:click="shipment({{$value->mark_id}})" class="ms-auto">
                            <i class="fa fa-truck"></i>Yuk
                        </a>
                    </td>
                    <td>{{ $value->price }}</td>
                    <td><input type="text" class="form-control form-control-sm" name="mark[{{$value->mark_id}}][price]"
                               wire:model="mark.{{ $value->mark_id }}.price" autocomplete="off"></td>
                    <td>
                        <a href="javascript:void(0);" wire:click="getCode({{$value->mark_id}})" class="ms-auto">
                            <i class="fa fa-barcode"></i>IMEI
                        </a>
                    </td>
                </tr>
            @endforeach
        @endisset
        </tbody>

    </table>
    @include('admin.trade.components.get-code')
    @include('admin.trade.components.shipment')

</div>
