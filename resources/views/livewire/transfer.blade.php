<div>
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
                            </div>
                        </div>
                        <div class="card-body">
                            @include('admin.trade.components.cart-product')
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    @include('admin.trade.components.checkout.transfer')
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
