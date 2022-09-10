<table id="datatable" class="table table-bordered dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;" xmlns:wire="http://www.w3.org/1999/xhtml">
    <thead>
    <tr>
        <th>Nomi</th>
    </tr>
    </thead>
    <tbody>
    @forelse($allPriceTypes as $item)
        <tr>
            <th class="d-flex justify-content-between">
                <span>{{ $item->name }}</span>
                <div>
                    <a href="/price_types/{{ $item->id }}" class="link-warning" style="text-decoration: none;">Narx chiqarish</a>
                    <span class="btn-sm btn-soft-success" style="cursor: pointer; margin-left: 1rem;" wire:click="addPricing({{ $item->id }})">Narxlash (Excel)</span>
                    <span style="cursor: pointer;margin-left: 1rem;" wire:click="editPriceType({{ $item->toJson() }})"><i class="fa fa-pen"></i></span>
                </div>
            </th>
        </tr>
        @empty
    @endforelse
    </tbody>
</table>
@include('admin.price.components.price-type.pricing')
