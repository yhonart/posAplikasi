@foreach($productList as $pL)
<tr>
    <td>
        <button class="btn btn-default btn-block rounded-0 border-0 onClick-produk" data-id="{{$pL->idm_product_satuan}}">{{$pL->product_name}}</button>
    </td>
    <td>
        <input type="number" name="loadQty" id="loadQty" class="form-control form-control-sm form-control-border border-width-2" autocomplete="off" readonly>
    </td>
    <td>
        {{$pL->product_satuan}}
    </td>
    <td>
        {{number_format($pL->product_price_order,'0',',','.')}}
    </td>
</tr>
@endforeach