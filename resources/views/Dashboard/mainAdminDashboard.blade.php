@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">    
        <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg" style="width:100%;">
                        <span class="d-flex navbar-brand">Dashboard <i class="fa-solid fa-chart-line"></i></span>
        
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
        
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">                                
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link BTN-CLICK" href="#" data-link="dashPenjualan" data-toggle="tab" id="tabMenuDash">
                                        Penjualan Toko
                                    </a>
                                </li>
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link BTN-CLICK" href="#" data-link="displayPembelian" data-toggle="tab" id="tabMenuHistory">
                                        Pembelian
                                    </a>
                                </li>                                                             
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link BTN-CLICK" href="#" data-link="dashHutangPelanggan" data-toggle="tab" id="tabMenuHistory">
                                        Hutang Pelanggan
                                    </a>
                                </li>                                                             
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link BTN-CLICK" href="#" data-link="dashHutangToko" data-toggle="tab" id="tabMenuHistory">
                                        Hutang Toko
                                    </a>
                                </li>                                                             
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link BTN-CLICK" href="#" data-link="dashLaporanKeuangan" data-toggle="tab" id="tabMenuHistory">
                                        Laporan Keuangan
                                    </a>
                                </li>                                                             
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
        <section class="container-fluid">
            <div id="displayAdminDashboard"></div>
        </section>
    </div>
</div>

<script>    
    $(document).ready(function(){
        let route = "dashPenjualan",
            display = $("#displayAdminDashboard");
        displayDashboard(display, route);
        
        $('.BTN-CLICK').on('click', function (e) {
            e.preventDefault();
            let ell = $(this);
            route = ell.attr("data-link");
            display = $("#displayAdminDashboard");
            displayDashboard(display, route);
        });

        function displayDashboard(display, route){
            $.ajax({
                type : 'get',
                url : "{{route('home')}}/"+route,
                success : function(response){
                    display.html(response);
                }
            });
        }
    });
</script>
@endsection