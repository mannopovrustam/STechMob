<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <x-add_client>
        <x-slot name="size">50</x-slot>
        <x-slot name="opening">{{ $addClient }}</x-slot>
    </x-add_client>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <label class="form-label" for="client">Sana</label>
                <input class="form-control" style="width: 50%" type="date" required name="date" wire:model="date" value="{{ now()->format('Y-m-d') }}" id="example-date-input">
            </div>
            <div class="mb-3">
                <label class="form-label align-items-end justify-content-between d-flex" for="client">
                    <span>Mijoz</span><span class="text-success" style="cursor: pointer" wire:click="$set('addClient', 'true')">Qo'shish<span class="hot_key">M</span></span>
                </label>
                <select name="client_id" class="form-select" id="client" wire:model="client_id">
                    <option value=""></option>
                    @foreach(\App\Models\User::where('role', \App\Models\User::USER_ROLE['client'])->get() as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('admin.trade.components.discount')
        </div>
    </div>

    <div class="card border shadow">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Savdo xulosasi</h5>
        </div>
        <div class="card-body p-4">

            <?php
                $symbol = \App\Models\User::getCurrency()->first()->symbol ?? \App\Models\User::getCurrency()->first()?->title;
            ?>

            <div class="table-responsive">
                <table class="table mb-0">
                    <tbody>
                    <tr>
                        <td>Savdo Narxi :</td>
                        <td class="text-end">{{$symbol}} {{ round($cashSum,2) }}</td>
                        <?php $collections['money_sys'] = round($pay); ?>
                    </tr>
                    <tr>
                        <td class="align-items-end d-flex"><button class="btn btn-soft-warning pt-0 pb-0" type="button"
                                    wire:click="$set('addDiscount', 'true')"
                            >Chegirma</button> <span class="hot_key">C</span> : </td>
                        <td class="text-end"> {{$symbol}} {{ round($discount,2) }}</td>
                        <?php $collections['discount'] = round($discount); ?>

                    </tr>
                    <tr>
                        <td class="align-items-end d-flex"><button class="btn btn-soft-success pt-0 pb-0" type="button"
                                    wire:click="$set('addPay', 'true')"
                            >To'lov</button> <span class="hot_key">T</span> : </td>
                        <td class="text-end"> {{$symbol}} {{ round($getSum,2) }}</td>
                    </tr>
                    <tr class="bg-light">
                        <th>Umumiy summa :</th>
                        <td class="text-end">
                            <span class="fw-bold">
                                {{$symbol}} {{ round($getSum) }}
                                <?php
                                    $collections['money_get'] = round($getSum);
                                ?>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->
        </div>
    </div>

    @include('admin.trade.components.pay')

</div>
