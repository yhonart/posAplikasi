@extends('layouts.store')
@section('content')
<script src="{{asset('public/js/cashierButton.js')}}"></script>
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