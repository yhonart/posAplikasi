@php
$customerStatus = array(
        0=>"Non Aktif",
        1=>"Aktif",
    );
@endphp
<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Edit Pelanggan</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="card-body">
        <form id="FormEditCustomer">
            <input type="hidden" name="customerID" id="customerID" value="{{$id}}">
            <input type="hidden" name="editorName" id="editorName" value="{{ Auth::user()->name }}">
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Kode Pelanggan</label>
                <div class="col-md-4">
                    <input type="text" name="Customer" id="Customer" value="{{$editCustomer->customer_code}}" class="form-control form-control-sm text-uppercase rounded-0" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Nama Pelanggan</label>
                <div class="col-md-4">
                    <input type="text" name="Customer" id="Customer" value="{{$editCustomer->customer_store}}" class="form-control form-control-sm text-uppercase rounded-0">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Alamat</label>
                <div class="col-md-4">
                    <input type="text" name="Address" id="Address" value="{{$editCustomer->address}}" class="form-control form-control-sm rounded-0">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Kota</label>
                <div class="col-md-4">
                    <input type="text" name="City" id="City" value="{{$editCustomer->city}}" class="form-control form-control-sm rounded-0">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">PIC</label>
                <div class="col-md-4">
                    <input type="text" name="pic" id="pic" value="{{$editCustomer->pic}}" class="form-control form-control-sm rounded-0">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Telefone</label>
                <div class="col-md-4">
                    <input type="text" name="phone" id="phone" value="{{$editCustomer->phone_number}}" class="form-control form-control-sm rounded-0" data-inputmask="'mask': ['9999-9999-9999', '+99 999-9999-9999']" data-mask>
                    <small class="text-info">Contoh +62 812-xxxx-xxxx (Gunakan kode negara +62)</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Tanggal Member</label>
                <div class="col-md-4">
                    <input type="text" name="registeredDate" id="registeredDate" value="{{$editCustomer->registered_date}}" class="form-control form-control-sm rounded-0" data-inputmask="'mask': ['99-99-9999']" data-mask>
                    <small class="text-info">Gunakan format : DD-MM-YYYY</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Email</label>
                <div class="col-md-4">
                    <input type="email" name="emailUser" id="emailUser" value="{{$editCustomer->email}}" class="form-control form-control-sm rounded-0">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Jadwal Kirim</label>
                <div class="col-md-4">
                    <select name="Schedule" id="Schedule" class="form-control form-control-sm rounded-0">
                        <option value="{{$editCustomer->schedule_delivery}}" readonly>{{$editCustomer->schedule_delivery}}</option>
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
                        <option value="{{$editCustomer->payment_type}}" readonly>{{$editCustomer->payment_type}}</option>
                        <option value="Tunai">Tunai</option>
                        <option value="Tempo">Tempo</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Tipe Penjualan</label>
                <div class="col-md-4">
                    <select name="typePenjualan" id="typePenjualan" class="form-control form-control-sm rounded-0">
                        <option value="{{$editCustomer->customer_type}}" readonly>{{$editCustomer->group_name}}</option>
                        @foreach($cosGroup as $cg)
                            @if($cg->idm_cos_group <> $editCustomer->customer_type)
                            <option value="{{$cg->idm_cos_group}}">{{$cg->group_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Level</label>
                <div class="col-md-4">
                    <select name="Level" id="Level" class="form-control form-control-sm rounded-0">
                        <option value="{{$editCustomer->level}}" readonly>{{$editCustomer->level}}</option>
                        <option value="Gold">Gold</option>
                        <option value="Silver">Silver</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Sales</label>
                <div class="col-md-4">
                    <select name="Sales" id="Sales" class="form-control form-control-sm rounded-0">
                        <option value="{{$editCustomer->sales_code}}" readonly>{{$editCustomer->sales_name}}</option>
                        @foreach($sales as $s)
                            <option value="{{$s->sales_code}}">{{$s->sales_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Status</label>
                <div class="col-md-4">
                    <select name="Status" id="Status" class="form-control form-control-sm rounded-0">
                        <option value="{{$editCustomer->customer_status}}" readonly>{{$customerStatus[$editCustomer->customer_status]}}</option>
                        <option value="1">Aktif</option>
                        <option value="0">Non Aktif</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Kredit Limit</label>
                <div class="col-md-4">
                    <input name="kreditLimit" id="kreditLimit" class="form-control form-control-sm price-text rounded-0">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="submitCustomer" class="btn btn-success font-weight-bold btn-flat">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('[data-mask]').inputmask();
    $('.price-text').mask('000.000.000', {
            reverse: true
        });
    $(document).ready(function(){        
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Customers')}}",
            tableData = "TableDataCustomer",
            displayData = $("#displayTableCustomers");
            
            $("form#FormEditCustomer").submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: routeIndex + "/TableDataCustomer/PostEditTable",
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