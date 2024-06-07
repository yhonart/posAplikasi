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
        <div id="dataSumPrice"></div>
        <div class="card">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-12">
                        <p class="bg-info p-2"><i class="fa-solid fa-circle-info"></i> Edit langsung di dalam table, jika sudah selesai silahkan klik tombol <b>SELESAI</b> / tekan <b>ESC</b>.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-sm table-hover" id="tableTrx">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Satuan</th>
                                    <th>Harga satuan</th>
                                    <th>Discount</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataTransaksi as $dtTrx)
                                    <tr>
                                        <td>
                                            {{$dtTrx->product_name}}
                                        </td>
                                        <td contenteditable="true" onBlur="saveToEditReturn(this,'tr_store_prod_list','qty','{{$dtTrx->list_id}}','list_id')" onClick="showEdit(this);">{{$dtTrx->qty}}</td>
                                        <td>
                                            <select name="editUnitPrice" id="editUnitPrice" class="form-control form-control-sm form-control-border border-width-2">
                                                <option value="{{$dtTrx->unit}}">{{$dtTrx->unit}}</option>
                                                @foreach($unitList as $unList)
                                                    @if($dtTrx->product_code == $unList->core_id_product)
                                                        @if($dtTrx->unit <> $unList->product_satuan)
                                                            <option value="{{$unList->product_satuan}}">{{$unList->product_satuan}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm form-control-border border-width-2 unitPrice price-text" value="{{$dtTrx->unit_price}}" name="unitPrice" id="unitPrice" readonly>                            
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm form-control-border border-width-2 discountPrice price-text" value="{{$dtTrx->disc}}" name="unitPrice" id="unitPrice">
                                        </td>
                                        <td>{{number_format($dtTrx->t_price,'0',',','.')}}</td>                                        
                                    </tr>
                                @endforeach
                            </tbody>                            
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-foot p-2">
                <button class="btn btn-info">SELESAI</button>
            </div>
        </div>
        
        
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
        $('.price-text').mask('000.000.000', {reverse: true});
    });

    function showEdit(editTableObj) {
        $(editTableObj).css("background","#c7d2fe");
        $(editTableObj).mask('000.000.000', {reverse: true});
    }

    function saveToDatabase(editTableObj,tableName,column,id,priceId) {
        const routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");
        $(editTableObj).css("background","#FFF");
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataPenjualan/postEditItem",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.innerHTML+'&id='+id+'&priceId='+priceId,
            success: function(data){
                $(editTableObj).css("background","#FDFDFD");                
            }
        });
    }

    function ajaxLoadDataSum(trxCode){
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataReturn/sumDataInfo/"+trxCode,
            type: "GET",
            success: function(response){
                $("#dataSumPrice").html(response);                
            }
        });
    }
</script>
@endsection