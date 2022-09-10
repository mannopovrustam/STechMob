<div class="popup__add width__25 {{ $addCode }}" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card" xmlns:wire="http://www.w3.org/1999/xhtml">
        <div class="card-header bg-transparent border-bottom py-3 px-4">
            <h5 class="font-size-16 mb-0">IMEI <span style="font-size: small; color: #ccc">{{ \App\Models\Mark::find($addCodeMark)?->name }}</span></h5>
            <a href="javascript:void(0);" wire:click="$set('addCode', 'false')" class="ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <input type="file"
                       wire:model="code"
                       wire:keydown.enter="storeCode({{$addCodeMark}})">
                <button type="button"
                        class="order btn btn-success btn-sm"
                        wire:click="storeCode({{$addCodeMark}})">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>IMEI</th>
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-light">
                            <td><input type="text"
                                       wire:model="code"
                                       wire:keydown.enter="storeCode({{$addCodeMark}})"></td>
                            <td class="text-end">
                                <button type="button"
                                        class="order btn btn-success btn-sm"
                                        wire:click="storeCode({{$addCodeMark}})">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                        @if($addCodeMark && isset(session()->get('markCode')[$addCodeMark]))
                            @foreach(session()->get('markCode')[$addCodeMark] as $key => $value)
                                <tr class="bg-light">
                                    <td>
                                        {{ $value }}
                                        <input type="hidden" name="mark[{{$addCodeMark}}][code][]" value="{{ $value }}">
                                    </td>
                                    <td class="text-end">
                                        <button type="button"
                                                class="order btn btn-danger btn-sm"
                                                wire:click="removeCode({{$addCodeMark}},{{$key}})">
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