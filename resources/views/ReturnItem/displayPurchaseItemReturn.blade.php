@foreach($dspReturn as $dRet)
    <tr>
        <td>{{$dRet->product_name}}</td>
        <td>{{$dRet->received}}</td>
        <td>{{$dRet->unit}}</td>
        <td>{{$dRet->return}}</td>
        <td class="text-right">{{number_format($dRet->unit_price,'0',',','.')}}</td>
        <td class="text-right">{{number_format($dRet->total_price,'0',',','.')}}</td>
        <td>{{$dRet->stock_awal}}</td>
        <td>{{$dRet->stock_akhir}}</td>
        <td></td>
    </tr>
@endforeach
<script>
    $(function(){
        $("#qtyReturn").val('0').focus().select();
    })
    $(document).ready(function(){
        
    });
</script>