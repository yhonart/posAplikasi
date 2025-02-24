@foreach($productList as $pL)
<tr>
    <td colspan="2" class="p-0">
        <button class="btn btn-default btn-block rounded-0 border-0 onClick-produk" data-id="{{$pL->idm_product_satuan}}">{{$pL->product_name}}</button>
    </td>
    <td class="p-0">
        <input type="number" name="loadQty" id="loadQty" class="form-control form-control-sm form-control-border border-width-2" autocomplete="off" readonly>
    </td class="p-0">
    <td class="p-0">
        {{$pL->product_satuan}}
    </td class="p-0">
    <td class="text-right p-0">
        @foreach($getPrice as $gp)
            {{number_format($gp->price_sell,'0',',','.')}}
        @endforeach
    </td>
    <td class="p-0">

    </td>
    <td class="p-0">

    </td>
    <td class="p-0">

    </td>
</tr>
@endforeach