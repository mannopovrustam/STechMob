<div class="popup__add width__25 {{ $getCode }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card" xmlns:wire="http://www.w3.org/1999/xhtml">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">IMEI <span style="font-size: small; color: #ccc">{{ \App\Models\Mark::find($getCodeMark)?->name }}</span></h5>
            <a href="javascript:void(0);" wire:click="$set('getCode', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>IMEI</th>
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($getCodeMark && isset(session()->get('markCode')[$getCodeMark]))
                            <?php
                                $productCode = \App\Models\ProductCode::whereIn('id', session()->get('markCode')[$getCodeMark])->get()
                            ?>
                            @foreach($productCode as $key => $value)
                                <tr class="bg-light">
                                    <td>
                                        {{ $value->code }}
                                        <input type="hidden" name="mark[{{$getCodeMark}}][code][]" value="{{ $value->id }}">
                                    </td>
                                    <td class="text-end">
                                        <button type="button"
                                                class="order btn btn-danger btn-sm"
                                                wire:click="removeCode({{$getCodeMark}},{{$value->id}})">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>