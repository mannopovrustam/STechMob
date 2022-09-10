<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div wire:click="$set('currencyPopup', 'true')" style="cursor: pointer">
        @forelse($currencies as $key => $item)
        <div class="dropdown d-none d-lg-inline-block ms-1 p-1">
            <span>{{ $item->title }}</span>
            <p style="margin-bottom: 0;">{{ $item->rate }}</p>
        </div>
        @empty
            <div class="dropdown d-none d-lg-inline-block ms-1 p-1">
                <span>Valyuta</span>
                <p style="margin-bottom: 0;">qo'shish</p>
            </div>
        @endforelse
    </div>
    <div class="popup__add width__25 {{ $currencyPopup }}" xmlns:wire="http://www.w3.org/1999/xhtml">
        <div class="card">
            <div class="card-header bg-transparent border-bottom py-3 px-4">
                <h5 class="font-size-16 mb-0">Valyuta</h5>
                <a href="javascript:void(0);" wire:click="$set('currencyPopup', 'false')" class="ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>
            <div class="card-body p-4">

                @if(Session::get('checkCurrency'))
                    <p>{{ Session::get('checkCurrency') }}</p>
                @endif

                <div class="table-responsive" style="height: 100%;">
                    <table class="table mb-5">
                        <thead>
                        <tr>
                            <th>
                                <div class="add-input">
                                    <div class="spinner-border text-info m-1" wire:loading
                                         wire:target="addCurrency({{count($currencies)}})" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <button class="btn text-white btn-info btn-sm"
                                            wire:loading.attr="disabled"
                                            wire:click.prevent="addCurrency({{count($currencies)}})">
                                        <i class="fa fa-plus"></i></button>
                                </div>
                            </th>
                            <th>Nomi</th>
                            <th>Baho</th>
                        </tr>
                        </thead>
                        <tbody>
                        <form wire:submit.prevent="storeCurrency">
                        @foreach($currencies as $key => $item)
                            <tr class="tab__tr">
                                <td><input type="hidden" class="form-control form-control-sm"
                                           wire:model="currency.{{$key}}.id" value="{{ $item->id }}"></td>
                                <td><input type="text" class="form-control form-control-sm"
                                           wire:model="currency.{{$key}}.title" value="{{ $item->title }}"></td>
                                <td><input type="text" class="form-control form-control-sm"
                                           wire:model="currency.{{$key}}.rate" value="{{ $item->rate }}"></td>
                            </tr>
                        @endforeach
                        @foreach($currencyInputs as $key => $value)
                            <tr class="tab__tr">
                                <td>
                                    <button class="btn btn-danger btn-sm" wire:click.prevent="removeCurrency({{$key}})">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="hidden" class="form-control form-control-sm"
                                           wire:model="currency.{{$key}}.id" value="{{ null }}">
                                </td>
                                <td><input type="text" class="form-control form-control-sm"
                                           wire:model="currency.{{$key}}.title"></td>
                                <td><input type="text" class="form-control form-control-sm"
                                           wire:model="currency.{{$key}}.rate"></td>
                            </tr>
                        @endforeach
                        <tr class="tab__tr">
                            <td></td>
                            <td></td>
                            <td class="text-right d-flex justify-content-end">
                                <button type="submit" class="btn-sm btn-soft-success">
                                    Saqlash
                                </button>
                            </td>
                        </tr>
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
