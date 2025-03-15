<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Tambah Supplier Baru</h3>
        <div class="card-tools">
            <button type="button" class="btn  btn-outline-danger" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="card-body">
        <form id="formAddSupplier">
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Kode Supplier</label>
                <div class="col-md-4">
                    <input type="text" name="kode" id="kode" class="form-control form-control-sm text-uppercase " value="{{$kodeSupplier}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Nama Supplier</label>
                <div class="col-md-4">
                    <input type="text" name="Supplier" id="Supplier" class="form-control form-control-sm text-uppercase ">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Alamat</label>
                <div class="col-md-4">
                    <input type="text" name="Address" id="Address" class="form-control form-control-sm ">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Kota</label>
                <div class="col-md-4">
                    <input type="text" name="City" id="City" class="form-control form-control-sm text-capitalize ">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Telefone</label>                
                <div class="col-md-4">
                    <input type="text" name="Phone" id="Phone" class="form-control form-control-sm " data-inputmask="'mask': ['9999-9999-9999', '+99 999-9999-9999']" data-mask>
                    <small class="text-info">Contoh +62 812-xxxx-xxxx (Gunakan kode negara +62)</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Admin Email</label>
                <div class="col-md-4">
                    <input type="email" name="Email" id="Email" class="form-control form-control-sm ">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Jadwal Kirim</label>
                <div class="col-md-4">
                    <select name="Schedule" id="Schedule" class="form-control form-control-sm ">
                        <option value="0" readonly></option>
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
                    <select name="paymentType" id="paymentType" class="form-control form-control-sm ">
                        <option value="0" readonly></option>
                        <option value="Tunai">Tunai</option>
                        <option value="Tempo">Tempo</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Nama Sales</label>
                <div class="col-md-4">
                    <input type="text" name="Salesman" id="Salesman" class="form-control form-control-sm text-uppercase ">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Level</label>
                <div class="col-md-4">
                    <select name="Level" id="Level" class="form-control form-control-sm ">
                        <option value="0" readonly></option>
                        <option value="Gold">Gold</option>
                        <option value="Silver">Silver</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Status</label>
                <div class="col-md-4">
                    <select name="Status" id="Status" class="form-control form-control-sm ">
                        <option value="0" readonly></option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tdk. Aktif">Tdk. Aktif</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="submitSupplier" class="btn btn-success font-weight-bold "><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('[data-mask]').inputmask();
    $(document).ready(function(){        
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Supplier')}}",
            tableData = "tableSupplier",
            displayData = $("#displayTableSupplier");
            
            $("form#formAddSupplier").submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: "{{route('Supplier')}}/AddSupliyer/PostSupplier",
                    type: 'POST',
                    data: new FormData(this),
                    async: true,
                    cache: true,
                    contentType: false,
                    processData: false,
                    success: function (data) {                    
                        window.location.reload();
                    },                
                });
                return false;
            });
    });
</script>