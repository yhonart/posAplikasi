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
                      <li class="breadcrumb-item">Pembelian</li>
                      <li class="breadcrumb-item">Retur Barang</li>
                    </ol>
                 </div>          
            </div>
        </div>
    </div>
<!-- content -->
    <div class="content">
        <div class="container-fluid">
            @if($checkArea <> 0)
            <div class="row mb-2">
                <div class="col-md-12">
                    <button class="btn btn-primary elevation-1 onclick-submenu " data-click="returnHistory"><i class="fa-regular fa-folder-open"></i> Retur List</button>                     
                    <button class="btn btn-primary elevation-1 onclick-submenu " data-click="purchasingList"><i class="fa-solid fa-dolly"></i> Retur Item</button>
                    <button class="btn btn-primary elevation-1 onclick-submenu " data-click="returnNonInv"><i class="fa-regular fa-folder-open"></i> Retur Non Invoice</button>                     
                </div>
            </div>
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