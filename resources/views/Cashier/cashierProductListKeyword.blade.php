@foreach($productList as $pL)
<tr>
    <td colspan="2" class="p-0">
        <button class="btn btn-default btn-block rounded-0 border-0 onClick-produk elevation-0" data-id="{{$pL->idm_product_satuan}}">{{$pL->product_name}}</button>
    </td>
    <td class="p-0"></td class="p-0">
    <td class="p-0">
        {{$pL->product_satuan}}
    </td class="p-0">
    <td class="text-right p-0">
        @foreach($getPrice as $gp)
            {{number_format($gp->price_sell,'0',',','.')}} {{$gp->cos_group}}
            @if($gp->core_product_price == $pL->idm_product_satuan)
            @endif
        @endforeach
    </td>
    <td class="p-0">{{$cosGroup}} / {{$pL->product_size}}</td>
    <td class="p-0"></td>
    <td class="p-0"></td>
</tr>
@endforeach