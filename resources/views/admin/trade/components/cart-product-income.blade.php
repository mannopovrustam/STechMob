<table id="datatable" class="table table-bordered dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;" xmlns:wire="http://www.w3.org/1999/xhtml">
    <thead>
    <tr>
        <th></th>
        <th>Brend</th>
        <th>Model</th>
        <th>Soni</th>
        <th>Narxi</th>
        <th>Summa</th>
        <th>Xarajat</th>
        <th>Tannarxi</th>
        <th>Izoh</th>
        <th>IMEI</th>
    </tr>
    </thead>
    <tbody>
    @forelse($marks as $key => $value)
        <tr>
            <td>
                <button class="btn-sm btn-danger" type="button" wire:click="removeMark({{$value->id ?? false}})"><i class="fa fa-minus"></i></button>
            </td>
            <td>{{ $value->brand->name }}</td>
            <td>{{ $value->name }} {{ $value->versiya }}</td>
            <td><input type="text" class="form-control form-control-sm" name="mark[{{$value->id}}][quantity]"
                       wire:model="mark.{{$value->id}}.quantity"
                       wire:change="$emit('markEvent')"></td>
            <td><input type="text" class="form-control form-control-sm" name="mark[{{$value->id}}][price]"
                       wire:model="mark.{{$value->id}}.price"
                       wire:change="$emit('markEvent')"></td>

            <?php
                $sum = 0; $expend = 0; $cost = 0; $expendSingle = 0;
                if (isset($mark[$value->id]['quantity']) && isset($mark[$value->id]['price'])){
                    $sum = (double)$mark[$value->id]['quantity']*(double)$mark[$value->id]['price'];
                    $expend = $expenseResult[$value->id] ?? 0;
                    $expendSingle = $expend/(double)$mark[$value->id]['quantity'];
                    $cost = (double)$mark[$value->id]['price'] + $expend/(double)$mark[$value->id]['quantity'];
                }
            ?>

            <td><span>{{ round($sum, 2) }}</span></td>
            <td>
                <span>{{ round($expend, 2) }} </span>
                <input type="hidden" name="mark[{{$value->id}}][expense]" value="{{ round($expendSingle,2) }}">
            </td>
            <td><span>{{ round($cost, 2) }}</span></td>
            <td><input type="text" class="form-control form-control-sm" name="mark[{{$value->id}}][note]"
                       wire:model="mark.{{$value->id}}.note"></td>
            <td><a href="javascript:void(0);" wire:click="addCode({{$value->id}})" class="ms-auto">
                    <i class="fa fa-barcode"></i>IMEI
                </a></td>
        </tr>
        @empty
    @endforelse
    </tbody>
</table>
@include('admin.trade.components.code')
