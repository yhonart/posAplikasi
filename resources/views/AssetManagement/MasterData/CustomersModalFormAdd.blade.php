<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Tambah Data Pelanggan</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="card-body">
        <form id="FormAddCustomer">
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Nama Pelanggan</label>
                <div class="col-md-4">
                    <input type="text" name="Customer" id="Customer" class="form-control form-control-sm text-uppercase ">
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
                    <input type="text" name="City" id="City" class="form-control form-control-sm ">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">PIC</label>
                <div class="col-md-4">
                    <input type="text" name="pic" id="pic" class="form-control form-control-sm ">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Telefone</label>
                <div class="col-md-4">
                    <input type="text" name="phone" id="phone" class="form-control form-control-sm " data-inputmask="'mask': ['9999-9999-9999', '+99 999-9999-9999']" data-mask>
                    <small class="text-danger">Contoh +62 812-xxxx-xxxx (Gunakan kode negara +62)</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Tanggal Member</label>
                <div class="col-md-4">
                    <input type="text" name="registeredDate" id="registeredDate" class="form-control form-control-sm ">
                    <small class="text-danger">Gunakan format tanggal : DD:MM:YYYY, Contoh : 29-02-2022</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Email</label>
                <div class="col-md-4">
                    <input type="email" name="emailUser" id="emailUser" class="form-control form-control-sm ">
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Jadwal Kirim</label>
                <div class="col-md-4">
                    <select name="Schedule" id="Schedule" class="form-control form-control-sm">
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
                <label class="form-label col-md-4 text-right">Tipe Penjualan</label>
                <div class="col-md-4">
                    <select name="typePenjualan" id="typePenjualan" class="form-control form-control-sm ">
                        @foreach($cosGroup as $cg)
                            <option value="{{$cg->idm_cos_group}}">{{$cg->group_name}}</option>                            
                        @endforeach
                    </select>
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
                <label class="form-label col-md-4 text-right">Sales</label>
                <div class="col-md-4">
                    <select name="Sales" id="Sales" class="form-control form-control-sm ">
                        <option value="0" readonly></option>
                        @foreach($sales as $s)
                            <option value="{{$s->sales_code}}">{{$s->sales_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="form-label col-md-4 text-right">Kredit Limit</label>
                <div class="col-md-4">
                    <input class="form-control form-control-sm  price-text" name="kreditLimit" id="kreditLimit">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="submitCustomer" class="btn btn-success font-weight-bold">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    $( function() {
        $( "#registeredDate" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#registeredDate').datepicker("setDate",new Date());
    } );
    
    $('[data-mask]').inputmask();
    $('.price-text').mask('000.000.000', {
            reverse: true
        });
    $(document).ready(function(){        
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Customers')}}",
            tableData = "TableDataCustomer",
            displayData = $("#displayTableCustomers");
            
            $("form#FormAddCustomer").submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: routeIndex + "/AddCustomers/PostNewCustomer",
                    type: 'POST',
                    data: new FormData(this),
                    async: true,
                    cache: true,
                    contentType: false,
                    processData: false,
                    success: function (data) { 
                        if(data.warning){
                            alertify
                              .alert(data.warning, function(){
                                alertify.message('Input Data Dibatalkan!');
                              }).set({title:"WARNING"});
                        }
                        else if(data.success){
                            alertify.success(data.success);
                            global_style.hide_modal();
                            window.location.reload();
                        }
                    },                
                });
                return false;
            });
    });
</script>