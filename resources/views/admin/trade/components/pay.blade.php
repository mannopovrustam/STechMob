<div class="popup__add width__25 {{ $addPay }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card" xmlns:wire="http://www.w3.org/1999/xhtml">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">To'lov</h5>
            <a href="javascript:void(0);" wire:click="$set('addPay', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>Kurs</th>
                        <th>Taklif</th>
                        <th class="text-end">Olindi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Models\User::getCurrency() as $currency)
                        <tr class="align-items-center">
                            <td>{{ $currency->title }}</td>
                            <td>
                                {{ isset($offer[$currency->id]) ? round($offer[$currency->id],2) : 0 }}
                                <input type="hidden" name="offer[{{$currency->id}}]"
                                       value="{{ isset($offer[$currency->id]) ? round($offer[$currency->id],2) : 0 }}">
                            </td>
                            <td class="text-end">
                                <input type="text" class="form-control" wire:model="currency.{{$currency->id}}" name="currency[{{$currency->id}}]">
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-light">
                        <td>{{ \App\Models\User::getCurrency()->first()?->title }}</td>
                        <td>{{ round($pay,2) }}</td>
                        <td class="text-end">
                            <span class="fw-bold">
                                {{ $symbol }} {{ round($getSum,2) }}
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>