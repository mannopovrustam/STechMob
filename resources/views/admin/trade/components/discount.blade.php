<div class="popup__add width__25 {{ $addDiscount }}" xmlns:wire="http://www.w3.org/1999/xhtml"
     xmlns:x-on="http://www.w3.org/1999/xhtml">
    <div class="card" xmlns:wire="http://www.w3.org/1999/xhtml">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Chegirma ({{ \App\Models\User::getCurrency()->first()->title }})</h5>
            <a href="javascript:void(0);" wire:click="$set('addDiscount', 'false')" x-on:keydown.escape="$set('addDiscount', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <div class="card-body p-4">
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-end">
                    <input class="form-control" type="text" id="discount" autofocus wire:model="discountValue" placeholder="Chegirma kiriting" autocomplete="off">
                    <div class="btn-group" style="margin-left: 1rem;" role="group"
                         aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="discount" wire:model="discountType" value="percentage" @checked($discountType == 'percentage') id="btnradio1">
                        <label class="btn btn-light mb-0" for="btnradio1">%</label>

                        <input type="radio" class="btn-check" name="discount" wire:model="discountType" value="money" @checked($discountType == 'money') id="btnradio2">
                        <label class="btn btn-light mb-0" for="btnradio2">{{ \App\Models\User::getCurrency()->first()->title }}</label>
                    </div>
                </div>
            </div>

            <?php
            $symbol = \App\Models\User::getCurrency()->first()->symbol ?? \App\Models\User::getCurrency()->first()?->title;
            ?>


            @if($cashSum != $pay)
                <div class="d-flex align-items-end justify-content-start">
                    <h6 style="margin: 0 .5rem; color: #c1c1c1"> <del> {{ round($cashSum,2) }}</del></h6>
                    <h5 style="margin: 0" class="text-start"><b>{{ round($pay,2) }}</b> {{$symbol}}</h5>
                </div>
            @endif
        </div>
    </div>
</div>