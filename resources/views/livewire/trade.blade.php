<div xmlns:wire="http://www.w3.org/1999/xhtml" wire:keydown.escape="hidePopup">

    <x-slot name="header">Savdo::<span class="text-primary">{{ $type }}</span></x-slot>
    <div class="container-fluid">
        <form wire:submit.prevent="storeTrade" method="post">
        {{--<form action="/trade" method="post">--}}
            @csrf

            <input type="hidden" name="trade_type" value="{{ \App\Models\Order::TRADE_TYPE[$trade] }}">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="searching__container">
                                    @livewire('search-product', ['type' => 'Trade'])
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="/trade/cash" class="btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="Naqd savdo" @if($trade == 'cash') style="border-bottom: 0.1rem solid #3ab449;" @endif>
                                        <img style="height: 2rem;" src="/assets/images/trade/money.png" alt="Github">
                                    </a>
                                    <a href="/trade/loan" class="btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="Nasiya" @if($trade == 'loan') style="border-bottom: 0.1rem solid #dbc49f;" @endif>
                                        <img style="height: 2rem;" src="/assets/images/trade/loan.png" alt="bitbucket">
                                    </a>
                                    <a href="/trade/installment" class="btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="Muddatli to'lov" @if($trade == 'installment') style="border-bottom: 0.1rem solid #f5f8f9;" @endif>
                                        <img style="height: 2rem;" src="/assets/images/trade/pay-day.png" alt="dribbble">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('admin.trade.components.cart-product')
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    @include('admin.trade.components.checkout.'.$trade)
                    <div class="card">
                        <div class="card-body text-center">
                            <button class="btn btn-info" style="width: 100%; margin-top: 1rem;">Rasmiylashtirish</button>
                            <button class="btn btn-link" style="margin-top: 1rem;">Tozalash</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@push('scripts')
    <script>
        document.onkeydown = function(e) {
            if (e.keyCode == 27) {window.livewire.emit('hidePopup')}
            if (e.keyCode == 77) {window.livewire.emit('addClient')}
            if (e.keyCode == 67) {window.livewire.emit('addDiscount')}
            if (e.keyCode == 84) {window.livewire.emit('addPay')}
        };
    </script>
@endpush

