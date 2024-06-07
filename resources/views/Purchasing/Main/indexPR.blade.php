@extends('layouts.frontpage')
@section('content')
<script src="{{asset('public/js/cashierButton.js')}}"></script>

<nav class="main-header navbar navbar-expand-md navbar-dark navbar-navy border-0">
    <div class="container">
        <a href="{{route('home')}}" class="navbar-brand">        
            <span class="brand-text font-weight-light"> <strong>Daz</strong>-POS</span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">                    
                    <a href="#" class="nav-link"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a>
                </li>                
            </ul>
        </div>
    </div>
</nav>
<div class="content-wrapper">
    <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-8 col-12">                        
                    </div>          
                </div>
            </div>
        </div>
    <!-- content -->
    <div class="content mt-0">
        <div class="container-fluid">
            @if($checkArea <> 0)
            <div class="row mb-2">
                <div class="col-12 col-md-4">
                    <div class="btn-group">
                        <button class="btn bg-indigo ml-1 elevation-1 font-weight-bold" data-click="purchRequest" id="pr">Purchase Request</button>                        
                        <button class="btn bg-indigo ml-1 elevation-1 font-weight-bold" data-click="purchOrder" id="productIn">Purchase Order</button>                        
                        <button class="btn bg-indigo ml-1 elevation-1 font-weight-bold" data-click="dashboard" id="Dashboard">Dashboard</button>                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive" style="height:700px;">
                            <div id="divPageProduct"></div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="alert alert-warning alert-dismissible text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            <span class="font-weight-bold">
                                User anda belum memiliki hak akses dikarenakan belum di setup area kerjanya, silahkan hubungi administrator untuk lebih lanjutnya!
                            </span>
                        </div>                        
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="modal MODAL-CASHIER" id="modal-global-sm" tabindex="-1" role="dialog" aria-labelledby="modalCashier" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content MODAL-CONTENT-CASHIER">
                <!-- Content will be placed here -->
                <!-- class default MODAL-BODY-GLOBAL -->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let routeIndex = "{{route('Purchasing')}}",
            urlProductList = "purchOrder",
            panelProductList = $("#divPageProduct");

        cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
    });
    
</script>

@endsection