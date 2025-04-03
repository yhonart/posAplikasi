<div class="row mb-2">
    <div class="col-md-12">
        <button type="button" class="btn btn-light btn-sm mb-1 font-weight-bold" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <i class="fa-solid fa-pen-to-square"></i> Dokumen Pembelian
        </button>        
        <div class="collapse" id="collapseExample">
            <div class="card card-body text-xs">
                <div id="displayCollapseDokumen"></div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-12">
        <form class="form animate__animated animate__fadeIn" >
            <div class="form-group row">
                <div class="col-md-3">
                    <input type="hidden" name="purchaseCode" id="purchaseCode" value="{{$trxPO}}">
                    <input class="form-control form-control-sm border-info " name="noPO" id="noPO" placeholder="Nomor PO">
                </div>
                <div class="col-md-2">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend bg-success">
                            <span class="input-group-text">Item</span>
                        </div>
                        <input class="form-control border-2 border-success" name="subTotalSatuan" id="subTotalSatuan" value="{{number_format($sumTransaction->countProduct,'0',',','.')}}" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend bg-danger">
                            <span class="input-group-text"><i class="fa-solid fa-rupiah-sign"></i></span>
                        </div>
                        <input class="form-control font-weight-bold border-2 border-danger text-danger" name="subTotal" id="subTotal" value="{{number_format($sumTransaction->subTotal,'0',',','.')}}" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn  btn-success btn-sm font-weight-bold elevation-1" id="simpanPenerimaan"><i class="fa-solid fa-cart-shopping"></i> Simpan Pembelian</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        let routeIndex = "{{route('Purchasing')}}",
            dataIndex = "dataPurchasing",
            panelProductList = $("#divPageProduct"),
            purchaseCode = $("#purchaseCode").val(),
            noPO = $("#noPO").val(),
            subTotalSatuan = $("#subTotalSatuan").val(),
            dokNumber = "{{$trxPO}}";
            subTotal = $("#subTotal").val();

        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/collapseDokumen/"+dokNumber,
            success : function(response){
                $("#displayCollapseDokumen").html(response);
            }
        });
            
        $("#simpanPenerimaan").on('click', function(){
            $("#simpanPenerimaan").hide();
            $.ajax({
                url: "{{route('Purchasing')}}/tableInputBarang/postTableSum",
                type: 'POST',
                data: {purchaseCode:purchaseCode,noPO:noPO,subTotalSatuan:subTotalSatuan,subTotal:subTotal},
                success: function (data) {
                    loadData(dataIndex);
                }
            });
        }) 
            
        function loadData(dataIndex){
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/"+dataIndex,
                success : function(response){
                    $("#divPageProduct").html(response);
                }
            });
        }
    });
</script>