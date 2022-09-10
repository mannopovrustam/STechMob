<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4>Narx Turi</h4>
                        <button type="button" class="btn-sm btn-soft-success"
                                wire:click="$set('addPriceType', 'true')">Qo'shish
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @include('admin.price.components.price-type.price-type-list')
                </div>
            </div>
        </div>
        @include('admin.price.components.price-type.add-price-type')
    </div>
</div>
