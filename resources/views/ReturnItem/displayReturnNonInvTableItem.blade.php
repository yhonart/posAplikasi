@foreach($getItem as $gI)
    <tr>
        <td>{{$gI->product_name}}</td>
        <td>{{$gI->unit}}</td>
        <td>{{$gI->site_name}}</td>
        <td>{{$gI->return}}</td>
        <td>{{$gI->unit_price}}</td>
        <td>{{$gI->total_price}}</td>
        <td>{{$gI->stock_awal}}</td>
        <td>{{$gI->stock_akhir}}</td>
        <td>{{$gI->item_text}}</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger btn-block btn-flat"><i class="fa-solid fa-xmark"></i></button>
        </td>
    </tr>
@endforeach