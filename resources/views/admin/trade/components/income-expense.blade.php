<div class="popup__add width__75 {{ $addExpense }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">Xarajat</h5>
            <a href="javascript:void(0);" wire:click="$set('addExpense', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <style>
            .checking__list {
                position: absolute;
                top: 120%;
                left: 0;
                display: none;
                border: 1px solid #fff;
                border-radius: 5px;
                padding: 5px;
            }

            .checking__list.true {
                display: block !important;
            }

            .checking__list.false {
                display: none !important;
            }

            /*.tab__td:focus-within .checking__list {*/
            /*display: block!important;*/
            /*}*/
            .checking__list > div {
                border-bottom: 1px solid #ffffff50;
                padding-bottom: 0;
            }

            .checking__list > div:last-child {
                border-bottom: 0;
            }
        </style>

        <div class="card-body p-4">
            <div class="table-responsive" style="height: 100%;">


                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>
                            <div class="add-input">
                                <div class="spinner-border text-info m-1" wire:loading
                                     wire:target="addExpense({{$expenseInputsLoop}})" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <button class="btn text-white btn-info btn-sm"
                                        wire:loading.attr="disabled"
                                        wire:click.prevent="addExpense({{$expenseInputsLoop}})">
                                    <i class="fa fa-plus"></i></button>
                            </div>
                        </th>
                        <th>Nomi</th>
                        <th>Summa</th>
                        <th>Tur</th>
                        <th>Izoh</th>
                        <th>Model
                            <button class="btn-sm btn-soft-success" type="button"
                                    wire:click="calculateExpense()">
                                <i class="fa fa-circle"></i></button>
                        </th>
                        <th class="text-end">Mijoz</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenseInputs as $key => $value)
                        <tr class="tab__tr">
                            <td>
                                <button class="btn btn-danger btn-sm"
                                        wire:click.prevent="removeExpense({{$key}})"><i
                                            class="fa fa-minus"></i></button>
                            </td>
                            <td><input type="text" class="form-control form-control-sm"
                                       wire:model="expense.{{$key}}.name"></td>
                            <td><input type="text" class="form-control form-control-sm"
                                       wire:model="expense.{{$key}}.price"></td>
                            <td>
                                <select class="form-select form-select-sm" wire:model="expense.{{$key}}.type">
                                    <option value="{{ \App\Models\Expense::TYPE['total'] }}">Umumiy</option>
                                    <option value="{{ \App\Models\Expense::TYPE['piece'] }}">Dona</option>
                                    <option value="{{ \App\Models\Expense::TYPE['total%'] }}">Umumiy Foiz %</option>
                                    <option value="{{ \App\Models\Expense::TYPE['distribution'] }}">Taqsimlash %
                                    </option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm"
                                       wire:model="expense.{{$key}}.note"></td>
                            <td style="position: relative" class="tab__td">
                                <select class="form-select form-select-sm" multiple wire:model="expense.{{$key}}.mark">
                                    @foreach($marks as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-end">
                                <select class="form-select form-select-sm" wire:model="expense.{{$key}}.client">
                                    @foreach(\App\Models\User::where('role', \App\Models\User::USER_ROLE['client'])->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <table class="table mt-5">
                    <thead>
                    <tr>
                        <th>Valyuta</th>
                        <th class="text-end">Xarajat</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr class="bg-light mt-3">
                        <td>USD</td>
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
</div>
