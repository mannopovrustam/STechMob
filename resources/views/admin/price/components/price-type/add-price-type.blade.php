<div class="popup__add width__25 {{ $addPriceType }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Narx Turi</h5>
            <a href="javascript:void(0);" wire:click="$set('addPriceType', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <div class="card-body p-4">

            @if(Session::get('checkPriceType'))
                @if(is_array(Session::get('checkPriceType')))
                    @foreach(Session::get('checkPriceType') as $item)
                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            {{ $item }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        {{ Session::get('checkPriceType') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endif

                <form wire:submit.prevent="addPriceType">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="col-form-label-sm" for="validationCustom01">Narx Turi</label>
                        <input type="text" class="form-control form-control-sm" wire:model="collection.name"
                               id="validationCustom01" placeholder="Narx Turi" required="">
                    </div>
                </div>
                <button class="btn btn-primary mt-3" type="submit">Saqlash</button>
            </form>
        </div>
        <!-- end table-responsive -->
    </div>
</div>
