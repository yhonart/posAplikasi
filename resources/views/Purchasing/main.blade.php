@extends('layouts.sidebarpage')
@section('content')

    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembelian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-muted">Home</li>
                        <li class="breadcrumb-item text-muted">Pembelian</li>
                        <li class="breadcrumb-item text-info active">Transaksi Pembelian</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- content -->
    <div class="content mt-0">
        @if($checkArea <> 0)
        <div class="container-fluid">
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
                                    <a class="nav-link onclick-submenu font-weight-bold" href="#" data-click="addPurchasing" data-toggle="tab" id="pr">
                                        <i class="fa-solid fa-dolly"></i> Pembelian
                                    </a>
                                </li>                                                                                                 
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link onclick-submenu font-weight-bold" href="#" data-click="dataPurchasing" data-toggle="tab" id="productIn">
                                        <i class="fa-solid fa-file"></i> List Pembelian
                                    </a>
                                </li>                                                                                                 
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link onclick-submenu font-weight-bold text-danger" href="{{route('returnItem')}}" data-click="dataPurchasing" data-toggle="tab" id="linkPengembalian">
                                        <i class="fa-solid fa-rotate-left"></i> Pengembalian Barang
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
            <div class="row mb-2">                
                <div class="col-md-4" style="display: none;">
                    <select class="form-control " name="selectTransaksi" id="selectTransaksi">
                        <option value="0" readonly>Pilih transaksi hari ini.</option>
                        <option value="1" readonly>Transaksi Baru</option>
                        @foreach($selectTrx as $st)
                            <option value="{{$st->purchase_number}}">{{$st->purchase_number}} || {{$st->store_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="text-center LOAD-SPINNER" style="display:none;">    
                        <span class="spinner-grow spinner-grow-sm" role="status"></span> Fetching Data !
                    </div>
                   <div id="divPageProduct"></div>
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
<script>
    $(document).ready(function(){
        let routeIndex = "{{route('Purchasing')}}",
            dataIndex = "dataPurchasing",
            panelProductList = $("#divPageProduct");
        
            viewData(dataIndex);
        $("#selectTransaksi").select2();
        $('.onclick-submenu').on('click', function (e) {
            e.preventDefault();
            let dataIndex = $(this).attr('data-click');
            $("#selectTransaksi").val('0');
            viewData(dataIndex);
        });        
        $("#selectTransaksi").change(function(){
            let findTrx = $(this).find(":selected").val();
            if(findTrx === '1' || findTrx === '0'){
                viewData(dataIndex);
            }
            else{
                $.ajax({
                    type: 'get',
                    url: "{{route('Purchasing')}}/tablePenerimaan/editTable/"+findTrx,
                    success: function (response) {
                      $('#divPageProduct').html(response);
                    }
                })
            }
        })
        
        function viewData(dataIndex){ 
            $(".LOAD-SPINNER").fadeIn();
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/"+dataIndex,
                success : function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    $("#divPageProduct").html(response);
                }
            });
        }
    });
    
</script>

@endsection