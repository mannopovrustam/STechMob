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
    @foreach($marks as $key => $mark)
        <tr>
            <td>
                <button class="btn btn-danger" type="button" wire:click="removeMark({{$mark->id ?? false}})"><i class="fa fa-minus"></i></button>
            </td>
            <td>{{ $mark->brand->name }}</td>
            <td>{{ $mark->name }} {{ $mark->versiya }}</td>
            <td><input type="text" class="form-control form-control-sm"
                       wire:model="mark.{{$mark->id}}.quantity"
                       wire:change="$emit('markEvent')"></td>
            <td><input type="text" class="form-control form-control-sm"
                       wire:model="mark.{{$mark->id}}.price"
                       wire:change="$emit('markEvent')"></td>
            <td><span wire:model="mark.{{$mark->id}}.sum"></span></td>
            <td><span wire:model="mark.{{$mark->id}}.expense"></span></td>
            <td><span wire:model="mark.{{$mark->id}}.cost"></span></td>
            <td><input type="text" class="form-control form-control-sm" wire:model="mark.{{$mark->id}}.note"></td>
            <td>IMEI</td>
        </tr>
    @endforeach
    </tbody>
</table>
