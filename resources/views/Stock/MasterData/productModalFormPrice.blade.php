<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Pengaturan Harga Utama</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="card-body"> 
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="text-center bg-indigo">
                        <tr>
                            <th>Ukuran</th>
                            <th>Satuan</th>
                            <th>Stock</th>
                            <th>Isi Satuan</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mProdUnit as $mProdU)
                            <tr>
                                <td>{{$mProdU->product_size}}</td>
                                <td>{{$mProdU->product_satuan}}</td>
                                <td class="text-center" contenteditable="true" onBlur="saveToDatabase(this,'m_product_unit','stock','{{$mProdU->idm_product_satuan}}','idm_product_satuan')" onClick="showEdit(this);">{{$mProdU->stock}}</td>
                                <td class="text-center" contenteditable="true" onBlur="saveToDatabase(this,'m_product_unit','product_volume','{{$mProdU->idm_product_satuan}}','idm_product_satuan')" onClick="showEdit(this);">{{$mProdU->product_volume}}</td>
                                <td class="text-right" contenteditable="true" onBlur="saveToDatabase(this,'m_product_unit','product_price_order','{{$mProdU->idm_product_satuan}}','idm_product_satuan')" onClick="showEdit(this);">
                                    {{number_format($mProdU->product_price_order)}}
                                </td>
                                <td class="text-right" contenteditable="true" onBlur="saveToDatabase(this,'m_product_unit','product_price_sell','{{$mProdU->idm_product_satuan}}','idm_product_satuan')" onClick="showEdit(this);">
                                    {{number_format($mProdU->product_price_sell)}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Edit Table
    function showEdit(editTableObj) {
        $(editTableObj).css("background","#FBFF69");
        $(editTableObj).mask('000.000.000', {reverse: true});
    }
    function saveToDatabase(editTableObj,tableName,column,id,priceId) {
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('TransProduct')}}",
            tableData = "StockBarang",
            displayData = $("#diplayTransaction");

        $(editTableObj).css("background","#FFF");
        $.ajax({
            url: "{{route('Stock')}}/ProductMaintenance/PostEditProductPrice",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.innerHTML+'&id='+id+'&priceId='+priceId,
            success: function(data){
                $(editTableObj).css("background","#FDFDFD");
                global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
            }
        });
    } 
</script>