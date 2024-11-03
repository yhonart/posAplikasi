@extends('layouts.sidebarpage')

@section('content')
<!-- Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-8 col-12">          
                <h1 class="m-0">Transaksi Jual Beli <small>Edit Transaksi Backdate</small></h1>
            </div>          
        </div>
    </div>
</div>
<!-- content -->
<div class="content mt-0">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center mb-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="formFilteringData">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="label">Jenis Transaksi</label>
                                        <select name="jenisTrx" id="jenisTrx" class="form-control form-control-sm rounded-0">
                                            <option value="0"></option>
                                            <option value="1">Pembelian</option>
                                            <option value="2">Penjualan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="label">Dari Tgl.</label>
                                    <input type="text" class="form-control form-control-sm datetimepicker-input rounded-0" name="fromDate" id="fromDate" autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="label">Sd. Tgl.</label>
                                    <input type="text" class="form-control form-control-sm datetimepicker-input rounded-0" name="endDate" id="endDate" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary btn-flat"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="loadSpinner" style="display: none;">
                    <div class="spinner-grow spinner-grow-sm text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span class="font-weight-bold">Please Wait...</span>
                </div>
                <div id="actionDisplay"></div>
                <span id="notiveDisplay" class="font-weight-bold text-danger"></span>
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
    });

    $(document).ready(function() {
        
        $("form#formFilteringData").submit(function(event){
            event.preventDefault();
            let valFromDate = $("#fromDate").val(),
                valEndDate = $("#endDate").val(),
                valJenis  = $("#jenisTrx");
            $("#loadSpinner").fadeIn("slow");
            $.ajax({
                url: "{{route('trxJualBeli')}}/displayFiltering",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {  
                    if (valFromDate === "" || valEndDate === "" || valJenis === "0") {
                        alertify
                        .alert("<h5>Lengkapi jenis transaksi, dan range tanggal untuk pencarian data</h5>"+valFromDate, function(){
                            alertify.message('OK');
                        }).set('frameless', true);
                    }
                    else{
                        $("#actionDisplay").html(data);
                        $("#loadSpinner").fadeOut("slow");
                    }                  
                },                
            });
            return false;
        });
    });
</script>
@endsection