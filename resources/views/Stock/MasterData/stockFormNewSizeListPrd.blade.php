@foreach($listSizePrd as $ls)
<tr>
    <td>{{$ls->set_barcode}}</td>
    <td>{{$ls->product_size}}</td>
    <td>{{$ls->product_satuan}}</td>
    <td>{{$ls->product_volume}}</td>
    <td>{{$ls->product_price_order}}</td>
    <td>{{$ls->product_price_sell}}</td>
    <td>
        <button type="button" class="btn btn-danger" data-id="{{$ls->idm_product_satuan}}"><i class="fa-solid fa-xmark"></i></button>
    </td>
</tr>
@endforeach
