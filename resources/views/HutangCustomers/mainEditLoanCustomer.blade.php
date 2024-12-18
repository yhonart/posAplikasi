@extends('layouts.sidebarpage')
@section('content')
<!-- Header -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Piutang Pelanggan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6 d-lg-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item text-muted">Home</li>
                <li class="breadcrumb-item text-muted">Keuangan</li>
                <li class="breadcrumb-item text-info active">Piutang Pelanggan</li>
            </ol>
        </div>
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content mt-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <button type="button" class="btn bg-lightblue CLICK-AR" data-display="pembayaran">Pembayaran</button>
                <button type="button" class="btn btn-warning CLICK-AR" data-display="saldo">Saldo Hutang</button>
                <button type="button" class="btn bg-olive CLICK-AR" data-display="lapCustomer">Lap. Customer</button>
                <button type="button" class="btn bg-maroon CLICK-AR" data-display="setup">Setup</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">                    
                    <div class="card-body">                
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <label class="form-label">Pilih Display</label>
                                <div class="form-group">
                                    <select name="actionCode" id="actionCode" class="form-control">
                                        <option value="0">{{str_repeat(".", 15)}}</option>
                                        <option value="1">Pembayaran Hutang</option>
                                        <option value="3">Histori Pembayaran</option>
                                        <option value="2">Edit & Open Limit Hutang</option>
                                    </select>
                                </div>
                            </div>   
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Cari Nama Pelanggan</label>
                                    <select class="form-control select-pelanggan" id="cariNamaPelanggan" class="form-control ">
                                        <option value="0" readonly>Nama Pelanggan</option>
                                        @foreach($dbMCustomer as $dcs)
                                        <option value="{{$dcs->idm_customer }}">{{$dcs->customer_store}}</option>
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
                        <div class="row mb-2">
                            <div class="col-12">
                                <div id="reloadDisplay" style="display: none;">
                                    <div class="spinner-grow text-dark spinner-grow-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <span>Please Wait ....</span>
                                </div>
                                <div id="divDataPelunasan"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{asset('public/Document/ManualBookPembayaranHutang.pdf')}}" class="btn bg-light border-0" target="_blank">Dokumentasi Penggunaan.</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        // $('#cariNamaPelanggan').focus();
        $('.datetimepicker-input').datepicker("setDate",new Date());
        $('#cariNamaPelanggan').select2({
            theme: 'bootstrap4',
        });
        dataPinjaman();
    });
    
    $(document).ready(function() {
        let fromDate = $('#dariTanggal').val(),
            endDate = $('#sampaiTanggal').val(),
            valAction = $("#actionCode").val(),
            keyWord = $("#cariNamaPelanggan").find(":selected").val();
            timer_cari_member = null;
        
        $("#cariNamaPelanggan").change(function(){
            let keyWord = $(this).find(":selected").val();
                fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                valAction = $("#actionCode").val();

            searchData(keyWord, fromDate, endDate, valAction);
        });
        
        $("#actionCode").change(function(){
            let valAction = $(this).find(":selected").val();
                fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                keyWord = $("#cariNamaPelanggan").find(":selected").val(); 
                if(keyWord == ''){
                    keyWord = '0';
                }  
            searchData(keyWord, fromDate, endDate, valAction);
        });
        
        $("#dariTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                valAction = $("#actionCode").val(),
                keyWord = $("#cariNamaPelanggan").find(":selected").val();

                if(keyWord == ''){
                    keyWord = '0';
                }                
            searchData(keyWord, fromDate, endDate,valAction);
        });

        $("#sampaiTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                valAction = $("#actionCode").val(),
                keyWord = $("#cariNamaPelanggan").find(":selected").val();
                if(keyWord == ''){
                    keyWord = '0';
                }
                
            searchData(keyWord, fromDate, endDate, valAction);
        });
        

        function searchData(keyWord, fromDate, endDate, valAction){  
            $("#reloadDisplay").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPelunasan/funcData/"+keyWord+"/"+fromDate+"/"+endDate+"/"+valAction,
                success : function(response){
                    $("#reloadDisplay").fadeOut("slow");
                    $("#divDataPelunasan").html(response);
                }
            });
        }
    });
    function dataPinjaman(){
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/buttonAction/dataPelunasan/listDataPinjaman",
            success : function(response){
                $("#divDataPelunasan").html(response);
            }
        });
    }
</script>
@endsection