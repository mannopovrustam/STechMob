<div class="popup__add width__50 {{ $addTransfer }}" xmlns:wire="http://www.w3.org/1999/xhtml"
     xmlns:x-on="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Pul O'tkazma</h5>
            <a href="javascript:void(0);" wire:click="$set('addTransfer', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <div class="card-body p-4">

            @if(Session::get('checkEmployee'))
                @if(is_array(Session::get('checkEmployee')))
                    @foreach(Session::get('checkEmployee') as $item)
                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            {{ $item }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        {{ Session::get('checkEmployee') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endif
            <form wire:submit.prevent="storeTransfer">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="name">Sana</label>
                            <input class="form-control form-control-sm" type="date" required name="date"
                                   wire:model="collection.date" value="{{ now()->format('Y-m-d') }}" id="example-date-input">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="phone">Ombor</label>
                            <select name="" class="form-select form-select-sm" id="" wire:model="collection.warehouse_id">
                                @foreach(\App\Models\Warehouse::all() as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="phone">Valyuta</label>
                            <select name="" class="form-select form-select-sm" id="" wire:model="collection.currency_id">
                                @foreach(\App\Models\Currency::all() as $value)
                                    <option value="{{ $value->id }}">{{ $value->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="rent">Summa</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collection.sum"
                                   id="rent" placeholder="Summa">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="profit">Kassadagi pul (Dollar, so’m) ko’rinish</label>
                            <input type="text" class="form-control form-control-sm"
                                   id="profit" placeholder="Kassadagi pul" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="profit">Izoh</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collection.note"
                                   id="profit" placeholder="Dona Foyda N%">
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary mt-3" type="submit">Saqlash</button>
            </form>
        </div>
        <!-- end table-responsive -->
    </div>
</div>
