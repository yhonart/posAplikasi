<form class="form animate__animated animate__fadeIn" >
    <div class="form-group row">
        <div class="col-md-3">
            <input type="hidden" name="purchaseCode" id="purchaseCode" value="{{$trxPO}}">
            <input class="form-control form-control-sm rounded-0" name="noPO" id="noPO" placeholder="Nomor PO">
        </div>
        <div class="col-md-2">
            <div class="input-group input-group-sm mb-3 rounded-0">
                <div class="input-group-prepend">
                    <span class="input-group-text">Item</span>
                </div>
                <input class="form-control" name="subTotalSatuan" id="subTotalSatuan" value="{{number_format($sumTransaction->countProduct,'0',',','.')}}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm mb-3 rounded-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-rupiah-sign"></i></span>
                </div>
                <input class="form-control font-weight-bold" name="subTotal" id="subTotal" value="{{number_format($sumTransaction->subTotal,'0',',','.')}}">
            </div>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-flat btn-success btn-sm font-weight-bold elevation-1" id="simpanPenerimaan"><i class="fa-solid fa-cart-shopping"></i> Simpan Pembelian</button>
        </div>
    </div>
</form>


<script>
    $(document).ready(function(){
        let routeIndex = "{{route('Purchasing')}}",
            dataIndex = "dataPurchasing",
            panelProductList = $("#divPageProduct"),
            purchaseCode = $("#purchaseCode").val(),
            noPO = $("#noPO").val(),
            subTotalSatuan = $("#subTotalSatuan").val(),
            subTotal = $("#subTotal").val();
            
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