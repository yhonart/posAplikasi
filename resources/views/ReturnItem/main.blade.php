@extends('layouts.sidebarpage')
@section('content')
<!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">          
                    <h1 class="m-0">Retur Barang</h1>
                </div> 
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                      <li class="breadcrumb-item"><a href="#">Pembelian</li>
                      <li class="breadcrumb-item">Retur Barang</li>
                    </ol>
                 </div>          
            </div>
        </div>
    </div>
<!-- content -->
    <div class="content">
        <div class="container-fluid">
            @if($checkArea <> 0).
            <div class="row">
                <div class="col-12">
                   <div id="displayInfo"></div>
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
    $(function () {
        let display = "purchasingList";
        $.ajax({
            type : 'get',
            url : "{{route('returnItem')}}/"+display,
            success : function(response){
                $("#displayInfo").html(response);
            }
        });
    }); 
</script>

@endsection