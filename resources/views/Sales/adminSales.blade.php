@extends('layouts.frontpage')
@section('content')
<script type="text/javascript">
    const route_main = "{{route('sales')}}";
</script>
<div class="content mt-1">
    <div class="container-fluid">
        <section class=" content-header">

            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg" style="width:100%;">
                        <span class="d-flex navbar-brand">Admin Control</span>
        
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
        
                        <div class="collapse navbar-collapse table-responsive" id="navbarSupportedContent">
                            <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">
                                
                                <li class="nav-item">
                                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="mainDashboard" data-toggle="tab" id="tabMenuDash">
                                        Home
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">Master Data</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainUser" data-toggle="tab" id="tabMenuUser">User</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainCustomer" data-toggle="tab" id="tabMenuPelanggan">Customers</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainCategory" data-toggle="tab" id="tabMenuKategori">Category</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainUnit" data-toggle="tab" id="tabMenuProdukUnit">MOU</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainProduct" data-toggle="tab" id="tabMenuProduk">Product List</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">Inventory</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainStock" data-toggle="tab" id="tab-menu-stats">Stock</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainStockOpname" data-toggle="tab" id="tab-menu-settings">Stock Opname</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">Transaksi</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainPenjualan" data-toggle="tab" id="tabMenuPenjualan">Sale </a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainReturn" data-toggle="tab" id="tab-menu-settings">Return Item</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainReceivables" data-toggle="tab" id="tab-menu-settings">Receivables</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">Report</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainSalesReport" data-toggle="tab" id="tabMenuPenjualan">Sales</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainDeliveryReport" data-toggle="tab" id="tab-menu-settings">Delivery</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainDailyReport" data-toggle="tab" id="tab-menu-settings">Daily</a>
                                    </div>
                                </li>                                
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
        <section class=" container-fluid">
            <div class="row">
                <div class="col-12">
                    <div id="divContent"></div>                    
                </div>
            </div>
        </section>
    </div>        
</div>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.ITEM-MAIN-MENU').on('click', function (e) {
            e.preventDefault();
            let path = $(this).attr('data-path');

            $("#div-content").load(route_main+'/'+path);
        });
        
    });
</script>
@endsection