@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">    
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-flat BTN-CLICK" data-link="dashPenjualan">
                        <i class="fa-solid fa-shop"></i> Penjualan Toko
                    </button>
                    <button type="button" class="btn btn-default btn-flat BTN-CLICK" data-link="displayPembelian">
                        <i class="fa-solid fa-cart-arrow-down"></i> Pembelian
                    </button>
                    <button type="button" class="btn btn-default btn-flat BTN-CLICK" data-link="dashHutangPelanggan">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Hutang Pelanggan
                    </button>
                    <button type="button" class="btn btn-default btn-flat BTN-CLICK" data-link="dashHutangToko">
                        <i class="fa-solid fa-file-invoice"></i> Hutang Toko
                    </button>
                    <button type="button" class="btn btn-default btn-flat BTN-CLICK" data-link="dashLaporanKeuangan">
                        <i class="fa-solid fa-file-lines"></i> Laporan Keuangan
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div id="displayAdminDashboard"></div>
            </div>
        </div>
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