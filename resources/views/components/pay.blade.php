<div class="popup__add width__{{$size}} {{ $opening }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card" xmlns:wire="http://www.w3.org/1999/xhtml">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">To'lov</h5>
            <a href="javascript:void(0);" wire:click="$set('addPay', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <div class="card-body p-4">

            <?php
            $pay = 112;
            ?>
            @livewire('pay', ['pay' => $pay])


        </div>
    </div>

</div>