@extends('layouts.sidebarpage')

@section('content')
<!-- Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-8 col-12">          
                <h1 class="m-0">Transaksi Pengeluaran <small>Biaya Operasional</small></h1>
            </div>          
        </div>
    </div>
</div>
<!-- content -->
<div class="content mt-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG btn-flat font-weight-bold" href="{{route('trxKasUmum')}}/tambahBiaya">Tambah Transaksi</button>
            </div>
        </div>
        <div class="row d-flex justify-content-center mb-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">                                
                            <div class="col-md-3">
                                <label for="" class="label">Dari Tgl.</label>
                                <input type="text" class="form-control form-control-sm datetimepicker-input rounded-0" name="fromDate" id="fromDate" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label for="" class="label">Sd. Tgl.</label>
                                <input type="text" class="form-control form-control-sm datetimepicker-input rounded-0" name="endDate" id="endDate" autocomplete="off">
                            </div>
                        </div>
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
        let fromDate = "0",
            endDate = "0";

        searchData(fromDate, endDate);

        $("#fromDate").change(function(){
                fromDate = $('#fromDate').val(),
                endDate = $('#endDate').val();

                if(fromDate === '' || endDate === ''){
                    fromDate = '0';
                    endDate = '0';
                }    
                searchData(fromDate, endDate)
        });

        $("#endDate").change(function(){
                fromDate = $('#fromDate').val(),
                endDate = $('#endDate').val();
                if(fromDate === '' || endDate === ''){
                    fromDate = '0';
                    endDate = '0';
                }  
                searchData(fromDate, endDate)
        });

        function searchData(fromDate, endDate){ 
            $.ajax({
                type : 'get',
                url : "{{route('trxKasUmum')}}/filterByDate/"+fromDate+"/"+endDate,
                success : function(response){
                    $("#actionDisplay").html(response);
                }
            });
        }
    });
</script>
@endsection