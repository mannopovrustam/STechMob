<div>

    <x-slot name="header">Savdo::<span class="text-primary">{{ $type }}</span></x-slot>
    <div class="container-fluid">
        <form action="/orders" method="post">
            @csrf

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
                                       title="Naqd savdo">
                                        <img style="height: 2rem;" src="/assets/images/trade/money.png" alt="Github">
                                    </a>
                                    <a href="/trade/loan" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Nasiya">
                                        <img style="height: 2rem;" src="/assets/images/trade/loan.png" alt="bitbucket">
                                    </a>
                                    <a href="/trade/installment" class="btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="Muddatli to'lov">
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
