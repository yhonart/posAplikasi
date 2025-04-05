@extends('layouts.frontpage')
@section('content')
<script src="{{asset('public/js/cashierButton.js')}}"></script>
<div class="content mt-0">
    <div class="container-fluid">
        @if($checkArea <> 0)            
        <div class="row">
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
    });
</script>

@endsection