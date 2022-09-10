<div class="popup__add width__25 {{ $popupPricing }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Narx chiqarish</h5>
            <a href="javascript:void(0);" wire:click="$set('popupPricing', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <div class="card-body p-4">

            @if(Session::get('checkPricing'))
                @if(is_array(Session::get('checkPricing')))
                    @foreach(Session::get('checkPricing') as $item)
                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            {{ $item }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        {{ Session::get('checkPricing') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endif

                @isset($collection['price_type_id'])
                    <div>
                        Excel formatda mahsulotlar bilan ularning narxini yuklang. <a href="#">NAMUNA</a><br><br>
                        <b>{{ \App\Models\PriceType::find($collection['price_type_id'])->name }}</b>
                        narx turiga avtomatik tarzda biriktiriladi!
                    </div>
                @endisset

                <form wire:submit.prevent="storePricing">
                    <input type="hidden" wire:model="collection.price_type_id">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="col-form-label-sm" for="pricing">Narxlash</label>
                            <input type="file" class="form-control form-control-sm" wire:model="collection.pricing"
                                   id="pricing" required="">
                        </div>
                    </div>
                <button class="btn btn-primary mt-3" type="submit">Saqlash</button>
            </form>
        </div>
        <!-- end table-responsive -->
    </div>
</div>
</div>
