<div>

    <form action="/income" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <div class="searching__container">
                                @livewire('search-product-income', ['type' => 'Income'])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.trade.components.cart-product-income')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('admin.trade.components.checkout.income')
                <div class="card">
                    <div class="card-body text-center">
                        <button class="btn btn-info" style="width: 100%; margin-top: 1rem;" type="submit">Rasmiylashtirish</button>
                        <button class="btn btn-link" style="margin-top: 1rem;">Tozalash</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
