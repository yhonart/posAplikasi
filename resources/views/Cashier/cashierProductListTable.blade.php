<?php
    $noProdList = "1";
?>
@foreach($listTrProduct as $ltrp)
<tr id="{{$ltrp->list_id}}">    
    <td class="text-xs">
        {{$noProdList++}}
    </td>
    <td class="text-xs">
        {{$ltrp->product_name}}
    </td>
    <td class="p-0">
        <input type="text" name="editQty[]" id="editQty{{$ltrp->list_id}}" class="form-control form-control-sm " value="{{$ltrp->qty}}" onchange="saveToPrdList(this,'tr_store_prod_list','qty','{{$ltrp->list_id}}','list_id','{{$ltrp->stock}}')" onfocus="this.select()" autocomplate="off">        
    </td>
    <td class="p-0">
        {{$ltrp->unit}}
    </td>
    <td class="p-0">
        <input type="text" name="editPriceSatuan" id="editPriceSatuan{{$ltrp->list_id}}" class="form-control form-control-sm  price-text text-right" value="{{$ltrp->unit_price}}" readonly>
    </td>
    <td class="p-0">
        <input type="text" name="editDisc[]" id="editDisc{{$ltrp->list_id}}" class="form-control form-control-sm " value="{{$ltrp->disc}}" onchange="saveToPrdList(this,'tr_store_prod_list','disc','{{$ltrp->list_id}}','list_id','{{$ltrp->stock}}')" onfocus="this.select()">
    </td>
    <td class="p-0">
        <input type="text" name="editTotalPrice" id="editTotalPrice{{$ltrp->list_id}}" class="form-control form-control-sm  price-text text-right" value="{{$ltrp->t_price}}" readonly>
    </td>
    <td class="text-center text-xs">
        {{$ltrp->stock}}
    </td>
    <td class="text-right p-0">
        <button type="button" class="btn btn-sm btn-danger DELETE-LIST elevation-1 " data-id="{{$ltrp->list_id}}"><i class="fa-solid fa-xmark"></i></button>
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
                alertify.confirm("Apakah anda yakin ingin menghapus item ?",
                function(){
                    $.ajax({
                        type : "get",
                        url : "{{route('Cashier')}}/buttonAction/dataPenjualan/deleteData/" + data,
                        success : function(response){
                            cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                            cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                        }
                    });
                    alertify.success('Item berhasil di hapus');
                },
                function(){
                    alertify.error('Cancel');
                });
        });
        
    });
    
    // EDIT TABLE
    function saveToPrdList(editTableObj,tableName,column,id,priceId,lastStock){
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataPenjualan/postEditItem",
            type: "POST",
            data:'tablename='+tableName+'&column='+column+'&editval='+editTableObj.value+'&id='+id+'&priceId='+priceId+'&lastStock='+lastStock,
            success: function(data){
                loadDataActive();
            }
        });
    }
    function savePrdUnit(editTableObj,tableName,column,id,priceId,prdID,prdQty){
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataPenjualan/postEditItemUnit",
            type: "POST",
            data:'tablename='+tableName+'&column='+column+'&editval='+editTableObj.value+'&id='+id+'&priceId='+priceId+'&prdID='+prdID+'&prdQty='+prdQty,
            success: function(data){
                loadDataActive();
            }
        });
    }
    
    function loadDataActive(){ 
        const routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");
            
        cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
        cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
    }
    
</script>