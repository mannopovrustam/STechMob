<table id="datatable" class="table table-bordered dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;" xmlns:wire="http://www.w3.org/1999/xhtml">
    <thead>
    <tr>
        <th>Foto</th>
        <th>Ism Sharifi</th>
        <th>Telefon</th>
        <th>Ijara</th>
        <th>Dona foyda (%)</th>
        <th>Oylik</th>
        <th>Oylik olish sanasi</th>
        <th>Bonus</th>
        <th>Asosiy valyuta</th>
        <th>Qo'shimcha valyuta</th>
    </tr>
    </thead>
    <tbody>
    @foreach($allTransfers as $item)
        {{--<tr>--}}
            {{--<th><img src="{{ storage_path('app/'.$item->employee->photo) }}" alt=""></th>--}}
            {{--<th>{{ $item->name }}</th>--}}
            {{--<th>{{ $item->phone }}</th>--}}
            {{--<th>{{ $item->employee->rent }}</th>--}}
            {{--<th>{{ $item->employee->profit }}</th>--}}
            {{--<th>{{ $item->employee->salary }}</th>--}}
            {{--<th>{{ $item->employee->salary_date }}</th>--}}
            {{--<th>{{ $item->employee->bonus ? 'Bor' : 'Yo\'q'}}</th>--}}
            {{--<th>--}}
                {{--@if($item->mainCurrency)--}}
                    {{--{{ $item->mainCurrency[0]->title }}--}}
                {{--@endif--}}
            {{--</th>--}}
            {{--<th class="d-flex justify-content-between">--}}
                {{--<div>--}}
                    {{--@if($item->secondCurrency)--}}
                        {{--@foreach($item->secondCurrency as $secondCurrency){{ $loop->first ? '' : ', ' }}{{ $secondCurrency->title }}@endforeach--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<span><i class="fa fa-pen" style="cursor: pointer" wire:click="editEmployee({{ $item->toJson() }})"></i></span>--}}
            {{--</th>--}}
        {{--</tr>--}}
    @endforeach
    </tbody>
</table>