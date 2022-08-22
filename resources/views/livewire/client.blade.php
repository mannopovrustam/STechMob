<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-bordered table-striped table-nowrap align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>FIO</th>
                    <th>Telefon</th>
                    <th>E-mail</th>
                    <th>Kod</th>
                    <th>Tuman</th>
                    <th>Manzil</th>
                    <th>Izoh</th>
                    <th>Harakat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key=>$value)
                    <tr data-id="{{ $key+1 }}">
                        <td style="width: 80px">{{ $key+1 }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->client->code ?? null }}</td>
                        <td>{{ $value->client->region_id ?? null }}</td>
                        <td>{{ $value->client->address ?? null }}</td>
                        <td>{{ $value->client->note ?? null }}</td>
                        <td style="width: 100px">
                            <a class="btn btn-outline-secondary btn-sm edit" wire:click="editClient({{ $value->id }})">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="/marks/{{ $value->id }}" style="display: inline-block" method="post">
                                @csrf
                                {{ method_field('delete') }}
                                <button type="submit" onclick="return confirm('Вы точно хотите удалить {{ $value->name }}');" class="btn btn-outline-secondary btn-sm">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->links() }}

    </div>
    <x-add_client>
        <x-slot name="size">50</x-slot>
        <x-slot name="opening">{{ $addClient }}</x-slot>
    </x-add_client>

</div>
