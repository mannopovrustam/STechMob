<div class="popup__add width__{{$size}} {{ $opening }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Mijoz Qo'shish</h5>
            <a href="javascript:void(0);" wire:click="$set('addClient', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <div class="card-body">
            {{--<form action="/clients" method="post" enctype="multipart/form-data">--}}
                {{--@csrf--}}
                <input type="hidden" wire:model="collections.id">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label-sm" for="name">FIO</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collections.name" id="name"
                                   placeholder="FIO">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label-sm" for="phone">Telefon</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collections.phone" id="phone"
                                   placeholder="Telefon">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label-sm" for="email">E-mail</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collections.email" id="email"
                                   placeholder="E-mail">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label-sm" for="code">Kod</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collections.code" id="code"
                                   placeholder="Kod">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label-sm" for="region_id">Tuman</label>
                            <select wire:model="collections.region_id" class="form-select form-select-sm" id="region_id">
                                @foreach(\App\Models\Region::all() as $item)
                                    <option value="{{ $item->id }}" @isset($collection['id']) @selected($collection['id'] == $item->id) @endisset>{{ $item->name_uz }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label-sm" for="address">Manzil</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collections.address" id="address"
                                   placeholder="Manzil">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label-sm" for="note">Izoh</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collections.note" id="note"
                                   placeholder="Izoh">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3 position-relative">
                            <label class="col-form-label-sm" for="validationCustom01" style="visibility: hidden">Добавить</label>
                            <br>
                            <input class="btn-sm btn-primary" type="button" wire:click="addNewClient()" value="Saqlash">
                        </div>
                    </div>
                </div>
            {{--</form>--}}
        </div>
    </div>
</div>