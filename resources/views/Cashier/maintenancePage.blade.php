@extends('layouts.frontpage')
@section('content')
<script src="{{asset('public/js/cashierButton.js')}}"></script>
<div class="content mt-1">
    <div class="container-fluid">
        @if($checkArea <> 0 && $checkGroup == 1)         
            <!-- jika module systemnya hanya kasir dan inventory saja  -->
            @if($module == "AM3")
                <div class="row mb-2">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg" style="width:100%;">                            
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">                            
                                <ul class="nav nav-pills mr-auto" id="main-menu-bar-helpdesk">                                
                                    <li class="nav-item">
                                        <a class="nav-link BTN-CLICK font-weight-bold" href="#" data-link="productList" data-toggle="tab" id="tabMenuDash">
                                            KASIR
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link BTN-CLICK font-weight-bold" href="#" data-link="StockBarang" data-toggle="tab" id="tabMenuHistory">
                                            BRAND
                                        </a>
                                    </li>                                                             
                                    <li class="nav-item">
                                        <a class="nav-link BTN-CLICK font-weight-bold" href="#" data-link="remainingStock" data-toggle="tab" id="tabMenuHistory">
                                            STOCK
                                        </a>
                                    </li>                                                             
                                    <li class="nav-item">
                                        <a class="nav-link BTN-CLICK font-weight-bold" href="#" data-link="dashHutangToko" data-toggle="tab" id="tabMenuHistory">
                                            LAPORAN
                                        </a>
                                    </li>                                                      
                                </ul>
                        </nav>                    
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="table-responsive text-xs p-0" style="height:300px;">
                            <div id="displayLoadInventory"></div>
                        </div>
                    </div>
                </div>
            @else
            <div class="row" id="displayKasir">
                <div class="col-12 col-lg-8 pr-0">
                    @include('Global.global_spinner')
                    <div class=" table-responsive text-xs p-0" style="height:700px;">
                        <div id="mainListProduct"></div>
                    </div>                    
                </div>
                <div class="col-12 col-lg-4">
                    <div id="mainButton"></div>
                </div>
            </div>
            @endif
        @elseif($checkArea <> 0 && $checkGroup <> 1)
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <div class="alert blue-alert alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        <p class="font-weight-bold">
                            User group area anda bukan "TOKO", silahkan rubah user group anda menjadi Work Group "TOKO". Silahkan hubungi Admin/SPV untuk mengubah Work Group.
                        </p>
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
<script>
    $(document).ready(function(){
        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");
        cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
        cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);

        // for am3 
        let codeModule = "{{$module}}";

        if (codeModule === "AM3") {
            let route = "productList",
            display = $("#displayLoadInventory");
            functionLoad(display, route);

            $('.BTN-CLICK').on('click', function (e) {
                e.preventDefault();
                let ell = $(this);
                route = ell.attr("data-link");
                display = $("#displayLoadInventory");
                functionLoad(display, route);
            });


            function functionLoad(display, route){
                $.ajax({
                    type : 'get',
                    url : "{{route('Cashier')}}/"+route,
                    success : function(response){
                        display.html(response);
                    }
                });
            }
        }
    });
</script>

@endsection