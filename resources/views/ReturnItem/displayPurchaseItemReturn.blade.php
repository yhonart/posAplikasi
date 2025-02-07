@foreach($dspReturn as $dRet)
    <tr>
        <td>{{$dRet->product_name}}</td>
        <td>{{$dRet->received}}</td>
        <td></td>
        <td>{{$dRet->unit}}</td>
        <td>{{$dRet->return}}</td>
        <td class="text-right">{{number_format($dRet->unit_price,'0',',','.')}}</td>
        <td class="text-right">{{number_format($dRet->total_price,'0',',','.')}}</td>
        <td>{{$dRet->stock_awal}}</td>
        <td>{{$dRet->stock_akhir}}</td>
        <td>{{$dRet->item_text}}</td>
        <td>
            <button type="button" class="btn btn-sm btn-outline-danger BTN-DELETE" data-id="{{$dRet->id_return}}"><i class="fa-solid fa-xmark"></i></button>
        </td>
    </tr>
@endforeach
<script>
    $(function(){
        $("#qtyReturn").val('0').focus().select();
    })
    $(document).ready(function(){
        $(".BTN-DELETE").on('click', function (e) {
            e.preventDefault();
            let el = $(this),
                idReturn = el.attr('data-id');
                
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/purchasingList/deleteItem/"+idReturn,
                    success : function(response){
                        reloadItemReturn();
                    }
                });
        });

        function reloadItemReturn(){
            let purchaseNumber = "{{$purchCode}}";
            $.ajax({
                type : 'get',
                url : "{{route('returnItem')}}/purchasingList/displayItemList/"+purchaseNumber,
                success : function(response){
                    $("#displayInfo").html(response);
                }
            });
        }
    });
</script>