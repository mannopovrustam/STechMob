<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div style="display: flex; justify-content: space-between;">
        <input type="text" style="width: 30rem; display: block"
               class="form-control"
               placeholder="FIO, Telefon, E-mail, Kod, Tuman, Manzil"
               autocomplete="off" wire:model="searchTerm">
        @if(collect($searchTermData)->count() > 0)
            <ul class="card searching ">
                @foreach(collect($searchTermData) as $key => $result)
                    <li>
                        <button class="btn btn-success" type="button" wire:click="addMark({{$result['id'] ?? false}})">
                            <i class="fa fa-plus"></i></button>
                        {{ $result['name'] . ' ' . $result['version'] .' / '. $result['type'] .' / '. $result['brand'] .' ('.$result['count'].')' }}
                    </li>
                @endforeach
            </ul>
        @endif
        <button type="button" wire:click="$set('addClient', 'true')" class="btn btn-success">Mijoz qo'shish</button>
    </div>
    <div>
        <x-add_client>
            <x-slot name="size">50</x-slot>
            <x-slot name="opening">{{ $addClient }}</x-slot>
        </x-add_client>
    </div>
</div>
