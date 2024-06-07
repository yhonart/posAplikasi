<?php
    $noList = '1';
?>
@foreach($groupProdList as $gpl)
    <tr>
        <td>{{$noList++}}</td>
        <td>{{$gpl->size_product}}</td>
        <td>{{$gpl->group_name}}</td>
        <td class="text-right">{{number_format($gpl->price_sell,0,',','.')}}</td>
        <td class="text-right">
        <button type="button" class="btn btn-danger DELETE-PRICE-SIZE" data-id="{{$gpl->idm_price_sell}}" data-tb="m_product_price_sell" data-col="idm_price_sell"><i class="fa-solid fa-xmark"></i></button>
        </td>
    </tr>
@endforeach

<script>
    $(".DELETE-PRICE-SIZE").on('click', function(e){
        e.preventDefault();
        let dataId = $(this).attr('data-id'),
            dataTb = $(this).attr('data-tb'),
            dataCol = $(this).attr('data-col'),
            dataIdProd = "{{$productID}}";

        $.ajax({
            url : "{{route('home')}}/GetGlobaDelete/WithDeleteId/"+dataId+"/"+dataTb+"/"+dataCol,
            type : 'GET',
            success : function (response) {
                dataTableGroup(dataIdProd)
            }
        })
    });
</script>