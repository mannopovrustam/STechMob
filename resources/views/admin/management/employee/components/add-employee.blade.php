<div class="popup__add width__50 {{ $addEmployee }}" xmlns:wire="http://www.w3.org/1999/xhtml"
     xmlns:x-on="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Xodim</h5>
            <a href="javascript:void(0);" wire:click="$set('addEmployee', 'false')" class="ms-auto">
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
            <form wire:submit.prevent="addEmployee">

                <input type="hidden" wire:model="collection.id" value="17">
                <input type="hidden" wire:model="collection.role" value="{{ \App\Models\User::USER_ROLE['employee'] }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="name">FIO</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collection.name"
                                   id="name" placeholder="FIO" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="photo">Rasm</label>
                            <input type="file" wire:model="collection.photo" id="photo"
                                   class="form-control-file form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="phone">Telefon</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collection.phone"
                                   id="phone" placeholder="Telefon" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" wire:model="collection.email"
                                   id="email" placeholder="Email" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="password">Parol</label>
                            <input type="password" class="form-control form-control-sm" wire:model="collection.password"
                                   id="password" placeholder="Parol">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="password_confirmation">Parolni tasdiqlang</label>
                            <input type="password" class="form-control form-control-sm"
                                   wire:model="collection.password_confirmation"
                                   id="password_confirmation" placeholder="Parolni tasdiqlang">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="rent">Arenda</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collection.rent"
                                   id="rent" placeholder="Arenda">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="profit">Dona Foyda N%</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collection.profit"
                                   id="profit" placeholder="Dona Foyda N%">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="exampleFormControlInput1">Bonus</label>
                            <div class="media">
                                <div class="square-switch">
                                    <input type="checkbox" id="bonus" switch="bool" wire:model="collection.bonus">
                                    <label class="mt-0" for="bonus" data-on-label="Bor" data-off-label="Yo'q"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="profit">Oylik</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collection.salary"
                                   id="salary" placeholder="Oylik">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label-sm" for="profit">Oylik berish sanasi</label>
                            <input type="text" class="form-control form-control-sm" wire:model="collection.salary_date"
                                   id="salary_date" placeholder="Oylik berish sanasi">
                        </div>
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
                </div>
                <button class="btn btn-primary mt-3" type="submit">Saqlash</button>
            </form>
        </div>
        <!-- end table-responsive -->
    </div>
</div>
