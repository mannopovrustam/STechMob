<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <form action="/orders" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4>Pul O'tkazmalari</h4>
                            <button type="button" class="btn-sm btn-soft-success" wire:click="$set('addTransfer', 'true')">Qo'shish</button>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.money.transfer.components.transfer-list')
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('admin.money.transfer.components.add-transfer')
</div>
