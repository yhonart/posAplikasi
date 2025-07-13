@extends('layouts.sidebarpage')
@section('content')
<!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">          
                    <h1 class="m-0">Pengembalian Barang</h1>
                </div> 
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                      <li class="breadcrumb-item">Pembelian</li>
                      <li class="breadcrumb-item">Pengembalian Barang</li>
                    </ol>
                 </div>          
            </div>
        </div>
    </div>
<!-- content -->
    <div class="content">
        @if($checkArea <> 0)
        <div class="container-fluid mb-2">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg" style="width:100%;">                        
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">                                
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link onclick-submenu font-weight-bold" href="#" data-click="returnNonInv" data-toggle="tab" id="productIn">
                                        <i class="fa-solid fa-plus"></i> Return Non Invoice
                                    </a>
                                </li>                                                                                               
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link onclick-submenu font-weight-bold" href="#" data-click="purchasingList" data-toggle="tab" id="pr">
                                        <i class="fa-solid fa-table-list"></i> List Dok.Pembelian
                                    </a>
                                </li>                                                                                                 
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link onclick-submenu font-weight-bold" href="#" data-click="returnHistory" data-toggle="tab" id="pr">
                                        <i class="fa-solid fa-table-list"></i> Riwayat Pengembalian
                                    </a>
                                </li>                                                                                                 
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        @endif
        
        <div class="container-fluid">
            @if($checkArea <> 0)
            <div class="row">
                <div class="col-md-12">
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
        let display = "returnHistory";
        $.ajax({
            type : 'get',
            url : "{{route('returnItem')}}/"+display,
            success : function(response){
                $("#displayInfo").html(response);
            }
        });
    }); 
    $(document).ready(function(){
        $('.onclick-submenu').on('click', function (e) {
            e.preventDefault();
            let dataIndex = $(this).attr('data-click');
            $("#selectTransaksi").val('0');
            $.ajax({
                type : 'get',
                url : "{{route('returnItem')}}/"+dataIndex,
                success : function(response){
                    $("#displayInfo").html(response);
                }
            });
        });
    });
</script>

@endsection