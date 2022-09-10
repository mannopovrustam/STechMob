<table id="datatable" class="table table-bordered dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;" xmlns:wire="http://www.w3.org/1999/xhtml">
    <thead>
    <tr>
        <th>Nomi</th>
    </tr>
    </thead>
    <tbody>
    @forelse($allPricing as $item)
        <tr>
            <th class="d-flex justify-content-between">
                <span>{{ $item->name }}</span>
            </th>
        </tr>
        @empty
    @endforelse
    </tbody>
</table>
