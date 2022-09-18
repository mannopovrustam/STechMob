<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <label class="form-label" for="example-date-input">Sana</label>
                <input class="form-control" style="width: 50%" type="date" name="date" value="{{ now()->format('Y-m-d') }}" id="example-date-input">
            </div>
            <div class="mb-3">
                <label class="form-label align-items-end justify-content-between d-flex" for="client">
                    <span>Ombor</span>
                </label>
                <select name="client_id" class="form-select" id="client">
                    @foreach(\App\Models\Warehouse::where('id', '!=', \App\Models\User::getWarehouse()->id)->get() as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
