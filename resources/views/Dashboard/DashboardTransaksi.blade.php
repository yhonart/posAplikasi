@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <!-- <div class="row">
        <div class="col-12">
            <div class="marquee">
                <div id="marquee">
                    <b>Last Update : Perbaikan Load & Hold di halaman kasir !</b>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">        
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Cari Dari Tanggal</label>
                    <input type="text" class="form-control form-control-sm form-control-border border-width-2 border-info datetimepicker-input" name="dariTanggal" id="dariTanggal">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">s.d Tanggal</label>
                    <input type="text" class="form-control form-control-sm form-control-border border-width-2 border-info datetimepicker-input" name="sampaiTanggal" id="sampaiTanggal">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Kasir</label>
                    <select name="namaKasir" id="namaKasir" class="form-control form_control-sm ">
                        <option value="0">All Kasir</option>
                        @foreach($userKasir as $uk)
                            <option value="{{$uk->name}}">{{$uk->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="loadDataDashboard"></div>
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
        $('#searchDataReturn').val('').focus();
    });
    
    $(document).ready(function(){
        let fromDate = $('#dariTanggal').val(),
            endDate = $('#sampaiTanggal').val();
        funcLoadDataTrx(fromDate, endDate, namaKasir);
            
        $("#dariTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                kasir = $('#namaKasir').val();
            
            funcLoadDataTrx(fromDate, endDate, namaKasir);
        });

        $("#sampaiTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                namaKasir = $("#namaKasir").val();
                
            funcLoadDataTrx(fromDate, endDate, namaKasir);
        });

        $("#namaKasir").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                namaKasir = $(this).val();
                
            funcLoadDataTrx(fromDate, endDate, namaKasir);
        });
        
        function funcLoadDataTrx(fromDate, endDate, namaKasir){
            $.ajax({
                type : 'get',
                url : "{{route('Dashboard')}}/loadDataTransaksi/"+fromDate+"/"+endDate+"/"+namaKasir,
                success : function(response){
                    $("#loadDataDashboard").html(response);
                }
            });
        };
        
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('TransProduct')}}",
            tableData = "StockBarang",
            displayData = $("#diplayTransaction");
        
        $('.ITEM-DISPLAY').on('click', function (e) {
            e.preventDefault();
            let tableData = $(this).attr('data-open');
            loadSpinner.fadeOut();
            displayData.load(routeIndex+"/"+tableData);
        });
        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>
@endsection