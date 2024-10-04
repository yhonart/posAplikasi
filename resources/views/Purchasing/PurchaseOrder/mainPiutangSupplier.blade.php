@extends('layouts.sidebarpage')
@section('content')
    <div class="content-header bg-light mb-2">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-8 col-12">          
                    <h1 class="m-0"><small>Transaksi</small> Piutang Supplier</h1>
                </div>          
            </div>
        </div>
    </div>
    <div class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="tableFilter"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function(){
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/Bayar",
                success : function(response){
                    $('#tableFilter').html(response);
                }
            });
        }
    </script>
@endsection