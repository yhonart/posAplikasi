@extends('layouts.sidebarpage')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lap. Kas Kecil</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item text-muted">Home</li>
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item text-info active">Lap. Kas Kecil</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content mt-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary CLIK-LAP font-weight-bold" data-display="laporanKasKecil"><i class="fa-solid fa-file-invoice-dollar"></i> Laporan</button>
                <button type="button" class="btn btn-primary CLIK-LAP font-weight-bold" data-display="dashboardKasKecil"><i class="fa-solid fa-chart-line"></i> Dashboard</button>
                <button type="button" class="btn btn-primary CLIK-LAP font-weight-bold" data-display="addModalKas"><i class="fa-solid fa-plus"></i> Tambah Saldo</button>
            </div>
        </div>
        <div id="displayLap"></div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        let display = "laporanKasKecil";
        displayOnClick(display);

        $('.CLIK-LAP').on('click', function (e) {
            e.preventDefault();
            let display = $(this).attr('data-display');
            displayOnClick(display);
        });

        function displayOnClick(display){
            $("#displayNotif").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('kasKecil')}}/"+display,
                success : function(response){
                    $('#displayLap').html(response);
                    $("#displayNotif").fadeOut("slow");
                }
            });
        }
    });
</script>
@endsection