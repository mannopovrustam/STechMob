<table id="datatable" class="table table-bordered dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;" xmlns:wire="http://www.w3.org/1999/xhtml">
    <thead>
    <tr>
        <th>Nomi</th>
        <th>Manzili</th>
        {{--<th>Xodimlar</th>--}}
        <th>Asosiy valyuta</th>
        <th>Qo'shimcha valyuta</th>
    </tr>
    </thead>
    <tbody>
    @forelse($allWarehouses as $item)
        <tr>
            <th>{{ $item->name }}</th>
            <th>{{ $item->address }}</th>
            {{--<th>{{ $item->address }}</th>--}}
            <th>
                @if(!$item->mainCurrency->isEmpty())
                    {{ $item->mainCurrency[0]->title }}
                @endif
            </th>
            <th class="d-flex justify-content-between">
                <div>
                    @if($item->secondCurrency)
                        @foreach($item->secondCurrency as $secondCurrency){{ $loop->first ? '' : ', ' }}{{ $secondCurrency->title }}@endforeach
                    @endif
                </div>
                <span><i class="fa fa-pen" style="cursor: pointer" wire:click="editWarehouse({{ $item->toJson() }})"></i></span>
            </th>
        </tr>
        @empty
    @endforelse
    </tbody>
</table>