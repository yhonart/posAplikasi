@foreach($listTrProduct as $ltrp)
<tr>
    <td>{{$ltrp->productName}}</td>
    <td class="text-center">{{$ltrp->qty}}</td>
    <td class="text-center">{{$ltrp->unit}}</td>
    <td class="text-right">{{number_format($ltrp->unit_price)}}</td>
    <td class="text-center">{{$ltrp->disc}}</td>
    <td class="text-right">{{number_format($ltrp->t_price)}}</td>
    <td></td>
    <td class="text-right">
        <button type="button" class="btn btn-sm btn-danger DELETE-LIST elevation-1" data-id="{{$ltrp->list_id}}"><i class="fa-solid fa-xmark"></i></button>
    </td>
</tr>

<script>
    $(document).ready(function(){
        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");

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
</script>
@endforeach