<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4>Narx Chiqarish</h4>
                        {{--<button type="button" class="btn-sm btn-soft-success"--}}
                                {{--wire:click="$set('addPriceType', 'true')">Qo'shish--}}
                        {{--</button>--}}
                    </div>
                </div>
                <div class="card-body">
                    @include('admin.price.components.pricing.pricing-list')
                </div>
            </div>
        </div>
    </div>
    {{--@include('admin.price.components.pricing.add-price-type')--}}
</div>
