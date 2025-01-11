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
                <button type="button" class="btn btn-info CLICK-AR" data-display="pembayaran"><i class="fa-solid fa-receipt"></i> Pembayaran</button>
                <button type="button" class="btn btn-success CLICK-AR" data-display="saldo"><i class="fa-solid fa-box-archive"></i> History</button>
                <button type="button" class="btn btn-primary CLICK-AR" data-display="lapCustomer"><i class="fa-regular fa-folder-open"></i> Lap. Customer</button>
                <button type="button" class="btn btn-warning CLICK-AR" data-display="setup"><i class="fa-solid fa-gear"></i> Setup</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="displayMenu"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).ready(function(){
        let display = "pembayaran";
        displayOnClick(display);

        $('.CLICK-AR').on('click', function (e) {
            e.preventDefault();
            let display = $(this).attr('data-display');
            displayOnClick(display);
        });

        function displayOnClick(display){
            $("#displayNotif").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('adminPiutangPelanggan')}}/"+display,
                success : function(response){
                    $('#displayMenu').html(response);
                    $("#displayNotif").fadeOut("slow");
                }
            });
        }
    });
</script>
@endsection