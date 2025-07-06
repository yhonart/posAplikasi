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
        
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">
                                
                                <li class="nav-item d-none d-md-block">
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
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainPenjualan" data-toggle="tab" id="tabMenuPenjualan">Penjualan</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainReturn" data-toggle="tab" id="tabMenuPengembalian">Pengembalian</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainReceivables" data-toggle="tab" id="tabMenuPiutang">Piutang</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">Report</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainSalesReport" data-toggle="tab" id="tabMenuPenjualan">Sales</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainDeliveryReport" data-toggle="tab" id="tabMenuPengiriman">Pengiriman</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="mainDailyReport" data-toggle="tab" id="tabMenuHarian">Harian</a>
                                    </div>
                                </li>                                
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">Pengaturan</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="configCustomer" data-toggle="tab" id="tabMenuConfigCustomer">Customer</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="configUser" data-toggle="tab" id="tabMenuConfigUser">User</a>
                                        <a class="dropdown-item ITEM-MAIN-MENU" href="#" data-path="configOther" data-toggle="tab" id="tabMenuConfigOther">Other</a>
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
                    <div class="modal MODAL-GLOBAL" id="modal-global-large" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content MODAL-CONTENT-GLOBAL">
                                <!-- Content will be placed here -->
                                <!-- class default MODAL-BODY-GLOBAL -->
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </section>
    </div>        
</div>
<script>
    $(function(){
        $("#divContent").load(route_main+'/mainDashboard');
    });
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.ITEM-MAIN-MENU').on('click', function (e) {
            e.preventDefault();
            let path = $(this).attr('data-path');
            // window.getSelection().removeAllRanges();
            $("#divContent").load(route_main+'/'+path);
        });
        
        const el_modal_all = $('.MODAL-GLOBAL'),
            el_modal_large = $('#modal-global-large'),
            id_modal_content = '.MODAL-CONTENT-GLOBAL';
        $(document).on('click','.BTN-OPEN-MODAL-GLOBAL-LG', function(e){
            e.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load($(this).attr('href'));
        });
        el_modal_all.on('show.bs.modal', function () {
            global_style.container_spinner($(this).find(id_modal_content));
        });
        el_modal_all.on('hidden.bs.modal', function () {
            $(this).find(id_modal_content).html('');
        });
    });
</script>
@endsection