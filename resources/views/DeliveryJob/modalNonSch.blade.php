<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">New Delivery Non Schedule</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form id="formNewDeliveryNonSch">
            <div class="form-group row">
                <label class="col-md-4">Pelanggan</label>
                <div class="col-md-4">
                    <select name="pelanggan" id="pelanggan" class="form-control form-control-sm">
                        <option value="0">== Pilih ==</option>
                        @foreach($customers as $cus)
                            <option value="{{$cus->customer_code}}">{{$cus->customer_store}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Produk</label>
                <div class="col-md-4">
                    <select name="produk" id="produk" class="form-control form-control-sm">
                        <option value="0">== Pilih ==</option>                        
                    </select>
                </div>
            </div>            
            <div class="form-group">
                <button class="btn btn-sm btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>