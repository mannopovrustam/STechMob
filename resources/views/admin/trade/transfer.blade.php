<x-app-layout>
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
                                    @livewire('search-product')
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <button class="btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Naqd savdo">
                                        <img style="height: 2rem;" src="assets/images/trade/money.png" alt="Github">
                                    </button>
                                    <button class="btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Nasiya">
                                        <img style="height: 2rem;" src="assets/images/trade/loan.png" alt="bitbucket">
                                    </button>
                                    <button class="btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Muddatli to'lov">
                                        <img style="height: 2rem;" src="assets/images/trade/pay-day.png" alt="dribbble">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @livewire('cart-product')
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <label class="form-label" for="client">Sana</label>
                                <input class="form-control" style="width: 50%" type="date" name="date" value="{{ now()->format('Y-m-d') }}" id="example-date-input">
                            </div>
                            <div class="mb-3">
                                <label class="form-label align-items-end justify-content-between d-flex" for="client">
                                    <span>Mijoz</span><span class="text-success">Qo'shish</span>
                                </label>
                                <select name="client" class="form-select" id="client">
                                    <option value="">John Doe</option>
                                </select>
                            </div>

                            @include('admin.trade.components.discount')

                        </div>
                    </div>
                    <div class="card border shadow">
                        <div class="card-header bg-transparent border-bottom py-3 px-4">
                            <h5 class="font-size-16 mb-0">Buyurtma xulosasi</h5>
                        </div>
                        <div class="card-body p-4">

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <td>Mahsulotlar Narxi :</td>
                                        <td class="text-end">$ 780</td>
                                    </tr>
                                    <tr>
                                        <td>Chegirma : </td>
                                        <td class="text-end">- $ 78</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <th>Umumiy summa :</th>
                                        <td class="text-end">
                                                                <span class="fw-bold">
                                                                    $ 702
                                                                </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-transparent border-bottom py-3 px-4">
                            <h5 class="font-size-16 mb-0">To'lov</h5>
                        </div>
                        <div class="card-body p-4">

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Kurx</th>
                                        <th>Taklif</th>
                                        <th class="text-end">Olindi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>USD</td>
                                        <td>223</td>
                                        <td class="text-end"><input type="text" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>UZS</td>
                                        <td>523000</td>
                                        <td class="text-end"><input type="text" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>EUR</td>
                                        <td>98</td>
                                        <td class="text-end"><input type="text" class="form-control"></td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td>USD</td>
                                        <td>383</td>
                                        <td class="text-end">
                                            <span class="fw-bold">386</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body text-center">
                            <button class="btn btn-info" style="width: 100%; margin-top: 1rem;">Rasmiylashtirish</button>
                            <button class="btn btn-link" style="margin-top: 1rem;">Tozalash</button>
                        </div>
                    </div>
                </div>
            </div>


            <x-popup>

            </x-popup>


        </form>
    </div>

</x-app-layout>