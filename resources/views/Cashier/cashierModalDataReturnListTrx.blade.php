@extends('layouts.frontpage')
@section('content')
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
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-8 col-12">                        
                </div>          
            </div>
        </div>
    </div>
    <div class="content mt-0">
        @include('Global.global_spinner')
        <div id="dataSumPrice"></div>
    </div>
</div>

<script>
    $(document).ready(function(){
        let trxCode = "{{$dataTrx}}";
        
        ajaxLoadDataSum(trxCode);

        $(".click-return").click(function(){
            let element = $(this) ;
            let dataRetur = element.attr("data-id"),
                dataTrx = element.attr("data-trx");
            $.ajax({
                type : "get",
                url: "{{route('Cashier')}}/buttonAction/dataReturn/clickRetur/" + idBrgReturn,
                success: function(response) {
                    $("#divDataReturn").html(response);
                }
            })
        }); 
        
    });

    
    

    function ajaxLoadDataSum(trxCode){
        $(".LOAD-SPINNER ").fadeIn('slow');
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataReturn/sumDataInfo/"+trxCode,
            type: "GET",
            success: function(response){
                $(".LOAD-SPINNER ").fadeOut('slow');
                $("#dataSumPrice").html(response);                
            }
        });
    }
</script>
@endsection