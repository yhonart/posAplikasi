@extends('layouts.sidebarpage')

@section('content')
<!-- Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-8 col-12">          
                <h1 class="m-0 animate__animated animate__slideInDown">Kas Kecil <small>Biaya Operasional</small></h1>
            </div>          
        </div>
    </div>
</div>
<!-- content -->
<div class="content mt-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <button class="btn btn-primary BTN-OPEN-MODAL-GLOBAL-LG border-0  font-weight-bold" href="{{route('trxKasUmum')}}/tambahBiaya"><i class="fa-solid fa-plus"></i> Tambah Transaksi</button>
                <a class="btn btn-outline-primary border-0 font-weight-bold" href="{{route('kasKecil')}}"><i class="fa-solid fa-file-invoice-dollar"></i> Laporan Kas Kecil</a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <label for="" class="label">Dari Tgl.</label>
                <input type="text" class="form-control form-control-sm datetimepicker-input " name="fromDate" id="fromDate" autocomplete="off">
            </div>
            <div class="col-md-3">
                <label for="" class="label">Sd. Tgl.</label>
                <input type="text" class="form-control form-control-sm datetimepicker-input " name="endDate" id="endDate" autocomplete="off">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <button type="button" class="btn btn-success btn-sm download-laporan" id="downloadExcel" export-type="excel"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
                        <button type="button" class="btn btn-danger btn-sm download-laporan" id="downloadPdf" export-type="pdf"><i class="fa-solid fa-file-pdf"></i> Download PDF</button>                        
                    </div>
                    <div class="card-body text-xs"> 
                        <div class="row">
                            <div class="col-md-12">                
                                <div id="actionDisplay"></div>
                                <span id="notiveDisplay" class="font-weight-bold text-danger"></span>
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
        $('.datetimepicker-input').datepicker("setDate",new Date());
    });

    $(document).ready(function() {
        let fromDate = $('#fromDate').val(),
            endDate = $('#endDate').val();
        
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

        $('.download-laporan').on('click', function (e) {
            e.preventDefault();
            let exportType = $(this).attr('export-type');
            fromDate = $('#fromDate').val(),
            endDate = $('#endDate').val();
            if(fromDate === '' || endDate === ''){
                fromDate = '0';
                endDate = '0';
            }  
            window.open("{{route('trxKasUmum')}}/exportData/"+exportType+"/"+fromDate+"/"+endDate,"_blank");            
        });

        function searchData(fromDate, endDate){ 
            $("#displayNotif").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('trxKasUmum')}}/filterByDate/"+fromDate+"/"+endDate,
                success : function(response){
                    $("#actionDisplay").html(response);
                    $("#displayNotif").fadeOut("slow");
                }
            });
        }
    });
</script>
@endsection