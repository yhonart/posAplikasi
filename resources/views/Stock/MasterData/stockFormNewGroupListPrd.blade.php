<?php
    $noList = '1';
?>
<table class="table table-valign-middle table-sm table-striped">
    <thead>
        <tr>
            <th>Ukuran</th>
            <th>Hrg. Beli</th>
            @foreach($mGroupCus as $mG)
                <th >{{$mG->group_name}}</th>
            @endforeach
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($mPrdUnit as $mPrd)
            <tr>
                <td class="p-0"><b>{{$mPrd->product_satuan}}/</b><small>{{$mPrd->product_size}}</small></td>
                <td class="p-0">
                    @if($mPrd->size_code == '1' OR $mPrd->product_price_sell == "")
                        <input class="form-control form-control-sm  EDIT-PRICE" name="editPriceOrder" id="eeditPriceOrder" value="{{$mPrd->product_price_order}}" onchange="saveToDatabase(this,'m_product_unit','product_price_order','{{$mPrd->idm_product_satuan}}','idm_product_satuan','{{$mPrd->core_id_product}}')">
                    @else
                        <input class="form-control form-control-sm text-right  EDIT-PRICE" value="{{$mPrd->product_price_order}}" readonly>
                    @endif
                </td>
                @foreach($mGroupCus as $mG1)
                    <td class="p-0">
                        @foreach($groupProdList as $gP)
                            @if( $gP->cos_group == $mG1->idm_cos_group AND $gP->size_product == $mPrd->product_size)
                                <input type="text" class="form-control form-control-sm  EDIT-PRICE" name="editPriceSell" id="editPriceSell" value="{{$gP->price_sell}}" onchange="saveToDatabase(this,'m_product_price_sell','price_sell','{{$gP->idm_price_sell}}','idm_price_sell','{{$mPrd->core_id_product}}')">
                            @endif
                        @endforeach
                    </td>
                @endforeach
                <td class="p-0">
                    <button type="button" class="btn btn-sm btn-danger DELETE-PRICE-SIZE float-right " data-id="{{$mPrd->core_id_product}}" data-size="{{$mPrd->product_size}}"><i class="fa-solid fa-xmark"></i></button>
                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
$(function(){
    $(".EDIT-PRICE").mask('000.000.000',{
            reverse: true,
        });
})
$(".DELETE-PRICE-SIZE").on('click', function(e){
    e.preventDefault();
    let dataId = $(this).attr('data-id'),
        dataSize = $(this).attr('data-size'),
        dataIdProd = "{{$idPrd}}";

    $.ajax({
        url : "{{route('Stock')}}/postDeleteItem/"+dataId+"/"+dataSize,
        type : 'GET',
        success : function (response) {
            funcTableHrg(dataIdProd)
        }
    });
});
function saveToDatabase(editTableObj,tableName,column,id,tableID,idProd) {
    let idInput = "{{$idPrd}}";
    $.ajax({
        url: "{{route('Stock')}}/ProductMaintenance/postEditProduct",
        type: "POST",
        data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.value+'&id='+id+'&tableID='+tableID+'&idProd='+idProd,
        success: function(data){
            funcTableHrg(idInput);
            Toast.fire({
                icon: 'success',
                title: column
            })
        }
    });
} 
function funcTableHrg(dataIdProd){        
    $.ajax({
        type : 'get',
        url : "{{route('Stock')}}/AddProduct/prodCategoryInput/"+dataIdProd,
        success : function(response){
            $("#displayTableHrg").html(response);
        }
    });
}
</script>