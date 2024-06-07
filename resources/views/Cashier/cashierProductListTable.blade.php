<?php
    $noProdList = "1";
?>
@foreach($listTrProduct as $ltrp)
<tr>
    <td>{{$noProdList++}}</td>
    <td>
        {{$ltrp->productName}}
        <input type="hidden" name="hiddenPrdID" id="hiddenPrdID" value="{{$ltrp->product_code}}">
    </td>
    <td class="text-center" contenteditable="true" onBlur="saveToDatabase(this,'tr_store_prod_list','qty','{{$ltrp->list_id}}','list_id')" onClick="showEdit(this);">
        {{$ltrp->qty}}
    </td>
    <td class="text-center">
        {{$ltrp->unit}}
    </td>
    <td class="text-right">
        
        <input type="text" name="editPriceSatuan" id="editPriceSatuan" class="form-control form-control-sm price-text text-right" value="{{$ltrp->unit_price}}" readonly>
    </td>
    <td class="text-center">
        {{$ltrp->disc}}
    </td>
    <td class="text-right">
        <input type="text" name="editTotalPrice" id="editTotalPrice" class="form-control form-control-sm price-text text-right" value="{{$ltrp->t_price}}" readonly>
    </td>
    <td class="text-center">{{$ltrp->stock}}</td>
    <td class="text-right">
        <button type="button" class="btn btn-sm btn-danger DELETE-LIST elevation-1" data-id="{{$ltrp->list_id}}"><i class="fa-solid fa-xmark"></i></button>
    </td>
</tr>
@endforeach
<script>
    $(document).ready(function(){
        const routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");
        $('.price-text').mask('000.000.000', {reverse: true});
        

        $('.DELETE-LIST').on('click', function(){
            let elThis = $(this),
                data = elThis.attr("data-id");
            $.ajax({
                type : "get",
                url : "{{route('Cashier')}}/buttonAction/dataPenjualan/deleteData/" + data,
                success : function(response){
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                }
            });
        });
        
    });
    // EDIT TABLE
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
                cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
            }
        });
    }
</script>