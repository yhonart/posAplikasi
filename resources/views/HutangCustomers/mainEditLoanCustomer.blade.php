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
        <section class=" content-header">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg" style="width:100%;">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
        
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">                                
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link CLICK-AR font-weight-bold" href="#" data-display="pembayaran" data-toggle="tab" id="summary">
                                        <i class="fa-solid fa-clipboard-list"></i> Summary Hutang
                                    </a>
                                </li>                                                                                               
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link CLICK-AR font-weight-bold" href="#" data-display="saldo" data-toggle="tab" id="riwayat">
                                        <i class="fa-solid fa-money-check-dollar"></i> Riwayat Pembayaran
                                    </a>
                                </li>                                                                                                 
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link CLICK-AR font-weight-bold" href="#" data-display="lapCustomer" data-toggle="tab" id="lapCustomer">
                                        <i class="fa-solid fa-users-between-lines"></i> Lap.Pelanggan
                                    </a>
                                </li>                                                                                                 
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link CLICK-AR font-weight-bold" href="#" data-display="setup" data-toggle="tab" id="setup">
                                        <i class="fa-solid fa-screwdriver-wrench"></i> Konfigurasi
                                    </a>
                                </li>                                                                
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
        
    </div>  
    <div class="container-fluid mb-2">        
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg" style="width:100%;">                        
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">                                
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link CLICK-AR font-weight-bold" href="#" data-display="pembayaran" data-toggle="tab" id="summary">
                                    <i class="fa-solid fa-clipboard-list"></i> Summary Hutang
                                </a>
                            </li>                                                                                               
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link CLICK-AR font-weight-bold" href="#" data-display="saldo" data-toggle="tab" id="riwayat">
                                    <i class="fa-solid fa-money-check-dollar"></i> Riwayat Pembayaran
                                </a>
                            </li>                                                                                                 
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link CLICK-AR font-weight-bold" href="#" data-display="lapCustomer" data-toggle="tab" id="lapCustomer">
                                    <i class="fa-solid fa-users-between-lines"></i> Lap.Pelanggan
                                </a>
                            </li>                                                                                                 
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link CLICK-AR font-weight-bold" href="#" data-display="setup" data-toggle="tab" id="setup">
                                    <i class="fa-solid fa-screwdriver-wrench"></i> Konfigurasi
                                </a>
                            </li>                                                                                                 
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="container-fluid">        
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