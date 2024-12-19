
<div class="card card-tabs">
    <div class="card-header">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link font-weight-bold active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Saldo Hutang Faktur</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-weight-bold" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Saldo Hutang Customers</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Cari Nama Pelanggan</label>
                            <select class="form-control select-pelanggan" id="fakturPelanggan" class="form-control ">
                                <option value="0" readonly>Nama Pelanggan</option>
                                @foreach($dbMCustomer as $dcs1)
                                <option value="{{$dcs1->idm_customer }}">{{$dcs1->customer_store}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="text" class="form-control datetimepicker-input" name="dariTanggal" id="dariTanggal">
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">s.d Tanggal</label>
                            <input type="text" class="form-control datetimepicker-input roundedd-0" name="sampaiTanggal" id="sampaiTanggal">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="divSaldoFaktur"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Cari Nama Pelanggan</label>
                            <select class="form-control select-pelanggan" id="kreditPelanggan" class="form-control ">
                                <option value="0" readonly>Nama Pelanggan</option>
                                @foreach($dbMCustomer as $dcs2)
                                <option value="{{$dcs2->idm_customer }}">{{$dcs2->customer_store}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="divSaldoCustomer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>    
    $(document).ready(function() {    
        let fakturPelanggan = $("#fakturPelanggan").find(":selected").val(),
            kreditPelanggan = $("#kreditPelanggan").find(":selected").val(),
            fromDate = $("#dariTanggal").val(),
            endDate = $("#sampaiTanggal").val();
        alert(fromDate);
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
        
        $('#fakturPelanggan').select2({
            theme: 'bootstrap4',
        });
        $('#kreditPelanggan').select2({
            theme: 'bootstrap4',
        });

        $("#fakturPelanggan").change(function(){
            let fakturPelanggan = $(this).find(":selected").val();  
            
        });
        
        $("#kreditPelanggan").change(function(){
            let kreditPelanggan = $(this).find(":selected").val();                
        });        
        
        selectFaktur (fakturPelanggan, fromDate, endDate);
        selectKredit (kreditPelanggan);

        function selectFaktur (fakturPelanggan, fromDate, endDate){
            $.ajax({
                type : 'get',
                url : "{{route('adminPiutangPelanggan')}}/saldoFaktur/"+fakturPelanggan+"/"+fromDate+"/"+endDate,
                success : function(response){
                    $('#divSaldoFaktur').html(response);
                }
            });
        }
        
        function selectKredit (kreditPelanggan){
            $.ajax({
                type : 'get',
                url : "{{route('adminPiutangPelanggan')}}/saldoCustomer/"+kreditPelanggan,
                success : function(response){
                    $('#divSaldoCustomer').html(response);
                }
            });
        }
    });
</script>