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
                    <div class="col-md-6 col-12">   
                        @if(!empty($namaToko))
                        <h3 class="m-0">Online Store {{$namaToko->company_name}}</h3>
                        @else
                        <h3 class="m-0">Online Store</h3>
                        @endif
                    </div>          
                </div>
            </div>
        </div>
    <!-- content -->
    <div class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="SearchProduk" id="SearchProduk" class="form-control form-control-border form-control-width-2 border-info" placeholder="Cari Produk" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="homeDisplayStore"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let keyWord = 0;
        searchData(keyWord);
        let timer_cari_equipment = null;
        $("#SearchProduk").keyup(function (e){
            e.preventDefault();
            clearTimeout(timer_cari_equipment);
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#SearchProduk").val().trim();
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord)},700)
        });
        
        function searchData(keyWord){        
            $.ajax({
                type : 'get',
                url : "{{route('Store')}}/cariProduk/"+keyWord,
                success : function(response){
                    $("#homeDisplayStore").html(response);
                }
            });
        }
    });
    
</script>

@endsection