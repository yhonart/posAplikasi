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
                                <li class="nav-item">
                                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="mainDashboard" data-toggle="tab" id="tabMenuDash">
                                        Home
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="mainProduct" data-toggle="tab" id="tabMenuProduct">
                                        Data Produk
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="mainCustomer" data-toggle="tab" id="tabMenuCustomer">
                                        Data Pelanggan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="mainSalesOrder" data-toggle="tab" id="tabMenuSalesOrder">
                                        Sales Order
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="mainDelivery" data-toggle="tab" id="tabMenuDelivery">
                                        Pengiriman
                                    </a>
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
                    <div class=" card card-body shadow border-0" style="min-height:73vh;" id="card-container-hd">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="divContent"></div>
                            </div>
                        </div>
                    </div>
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