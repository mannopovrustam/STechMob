<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <input type="text" style="width: 30rem;"
           class="form-control"
           placeholder="Nomi, Barcode, Maxsus kod"
           autocomplete="off" wire:model="searchTerm">
    @if(collect($searchTermData)->count() > 0)
        <ul class="card searching ">
            @foreach(collect($searchTermData) as $key => $result)
                <li>
                    <button class="btn btn-success" type="button" wire:click="addMark({{$result['id'] ?? false}})"><i class="fa fa-plus"></i></button>
                    {{ $result['name'] . ' ' . $result['version'] .' / '. $result['type'] .' / '. $result['brand'] .' ('.$result['count'].')' }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
