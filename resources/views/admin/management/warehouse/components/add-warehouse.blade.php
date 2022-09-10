<div class="popup__add width__50 {{ $addWarehouse }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Ombor</h5>
            <a href="javascript:void(0);" wire:click="$set('addWarehouse', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <style>
            .checking__list {
                position: absolute;
                top: 120%;
                left: 0;
                display: none;
                border: 1px solid #fff;
                border-radius: 5px;
                padding: 5px;
            }

            .checking__list.true {
                display: block !important;
            }

            .checking__list.false {
                display: none !important;
            }

            /*.tab__td:focus-within .checking__list {*/
            /*display: block!important;*/
            /*}*/
            .checking__list > div {
                border-bottom: 1px solid #ffffff50;
                padding-bottom: 0;
            }

            .checking__list > div:last-child {
                border-bottom: 0;
            }
        </style>

        <div class="card-body p-4">


            @if(Session::get('checkWarehouse'))
                @if(is_array(Session::get('checkWarehouse')))
                    @foreach(Session::get('checkWarehouse') as $item)
                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            {{ $item }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        {{ Session::get('checkWarehouse') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endif

                <form wire:submit.prevent="addWarehouse">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="col-form-label-sm" for="validationCustom01">Ombor nomi</label>
                        <input type="text" class="form-control form-control-sm" wire:model="collection.name"
                               id="validationCustom01" placeholder="Ombor nomi" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="col-form-label-sm" for="validationCustom02">Ombor
                            manzili</label>
                        <input type="text" class="form-control form-control-sm" wire:model="collection.address"
                               id="validationCustom02" placeholder="Ombor manzili" required="">
                    </div>


                    <div class="col-md-5 mb-3">
                        <label class="col-form-label-sm" for="main_currency_id">Valyuta</label>
                        <div class="d-flex justify-content-between">
                            <span class="small">Asosiy: </span>
                            <div class="btn-group" role="group"
                                 aria-label="Basic radio toggle button group">
                                @foreach(\App\Models\Currency::whereActive(1)->get() as $item)
                                    <input type="radio" class="btn-check" wire:model="collection.currency" wire:click="currencyChange()"
                                           id="{{ $item->title.$item->id }}" @if($loop->first) checked @endif value="{{ $item->id }}">
                                    <label class="btn-sm btn-light mb-0 mt-0"
                                           for="{{ $item->title.$item->id }}">{{ $item->title }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="small">Qoshimcha: </span>
                            <div class="btn-group" role="group"
                                 aria-label="Basic radio toggle button group">
                                @foreach(\App\Models\Currency::where('id', '!=', $collection['currency'] ?? 0)->whereActive(1)->get() as $key => $item)
                                    <input type="checkbox" class="btn-check" wire:model="collection.second_currency.{{ $key }}"
                                           id="second_{{ $item->title.$item->id }}" value="{{ $item->id }}">
                                    <label class="btn-sm btn-light mb-0 mt-0"
                                           for="second_{{ $item->title.$item->id }}">{{ $item->title }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1 mb-3"></div>
                    <div class="col-md-5 mb-3">
                        <label class="col-form-label-sm" for="main_currency_id">Narx turi</label>
                        <div class="d-flex justify-content-between">
                            <div class="btn-group" role="group"
                                 aria-label="Basic radio toggle button group">
                                @foreach(\App\Models\PriceType::all() as $item)
                                    <input type="radio" class="btn-check" wire:model="collection.price_type_id"
                                           id="{{ $item->title.$item->id }}" @if($loop->first) checked @endif value="{{ $item->id }}">
                                    <label class="btn-sm btn-light mb-0 mt-0"
                                           for="{{ $item->title.$item->id }}">{{ $item->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <button class="btn btn-primary mt-3" type="submit">Saqlash</button>
            </form>
        </div>
        <!-- end table-responsive -->
    </div>
</div>
</div>
