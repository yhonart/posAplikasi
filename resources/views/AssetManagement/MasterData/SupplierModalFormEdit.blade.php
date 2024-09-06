<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Edit Supplier {{$editSupplier->store_name}}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="card-body">
        <form id="formEditSupplier">
            <input type="hidden" name="suppID" id="suppID" value="{{$id}}">            
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Supplier ID</label>
                <div class="col-md-4">
                    <input type="text" name="Supplier" id="Supplier" class="form-control form-control-sm text-uppercase rounded-0" value="SUP{{sprintf("%07d",$id)}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Nama Supplier</label>
                <div class="col-md-4">
                    <input type="text" name="Supplier" id="Supplier" class="form-control form-control-sm text-uppercase rounded-0" value="{{$editSupplier->store_name}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Alamat</label>
                <div class="col-md-4">
                    <input type="text" name="Address" id="Address" class="form-control form-control-sm rounded-0" value="{{$editSupplier->address}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Kota</label>
                <div class="col-md-4">
                    <input type="text" name="City" id="City" class="form-control form-control-sm text-capitalize rounded-0" value="{{$editSupplier->city}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Telefone</label>                
                <div class="col-md-4">
                    <input type="text" name="Phone" id="Phone" class="form-control form-control-sm rounded-0" data-inputmask="'mask': ['9999-9999-9999', '+99 999-9999-9999']" data-mask value="{{$editSupplier->phone_number}}">
                    <small class="text-info">Contoh +62 812-xxxx-xxxx (Gunakan kode negara +62)</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Admin Email</label>
                <div class="col-md-4">
                    <input type="email" name="Email" id="Email" class="form-control form-control-sm rounded-0" value="{{$editSupplier->email}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Jadwal Kirim</label>
                <div class="col-md-4">
                    <select name="Schedule" id="Schedule" class="form-control form-control-sm">
                        <option value="0" readonly>{{$editSupplier->schedule_delivery}}</option>                        
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Tipe Pembayaran</label>
                <div class="col-md-4">
                    <select name="paymentType" id="paymentType" class="form-control form-control-sm rounded-0">
                        <option value="0" readonly>{{$editSupplier->payment_type}}</option>
                        <option value="Tunai">Tunai</option>
                        <option value="Tempo">Tempo</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Nama Sales</label>
                <div class="col-md-4">
                    <input type="text" name="Salesman" id="Salesman" class="form-control form-control-sm text-uppercase rounded-0" value="{{$editSupplier->salesman}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Level</label>
                <div class="col-md-4">
                    <select name="Level" id="Level" class="form-control form-control-sm">
                        <option value="0" readonly>{{$editSupplier->level}}</option>
                        <option value="Gold">Gold</option>
                        <option value="Silver">Silver</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Status</label>
                <div class="col-md-4">
                    <select name="Status" id="Status" class="form-control form-control-sm">
                        <option value="0" readonly>{{$editSupplier->supplier_status}}</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tdk. Aktif">Tdk. Aktif</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="submitSupplier" class="btn btn-success font-weight-bold">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('[data-mask]').inputmask();
    $(document).ready(function(){  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });      
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Supplier')}}",
            tableData = "tableSupplier",
            displayData = $("#displayTableSupplier");
            
            $("form#formEditSupplier").submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: "{{route('Supplier')}}/tableSupplier/PostSupplierEdit",
                    type: 'POST',
                    data: new FormData(this),
                    async: true,
                    cache: true,
                    contentType: false,
                    processData: false,
                    success: function (data) {                    
                        global_style.hide_modal();
                        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);                        
                    },                
                });
                return false;
            });
    });
</script>