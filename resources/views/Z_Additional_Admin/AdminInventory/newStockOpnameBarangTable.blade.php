<?php
    $no = '1';
    $total = '';
?>
@foreach($listBarang as $lBarang)
<tr>
    <td>{{$no++}}</td>
    <td>{{$lBarang->product_name}}</td>
    <td>{{$lBarang->product_satuan}}</td>
    <td>
        <input type="hidden" name="opnameNumber" id="opnameNumber" value="{{$lBarang->sto_number}}">
        <input type="number" class="form-control form-control-border form-control-sm" value="{{$lBarang->input_qty}}" name="inputQty" id="inputQty" onchange="saveToDatabase(this,'{{$lBarang->id_list}}','id_list')">        
    </td>
    <td>
        <input type="text" class="form-control form-control-border form-control-sm text-center" value="{{$lBarang->last_stock}}" name="inputLastStock" id="inputLastStock" readonly>        
    </td>
    <td>
        <input type="number" class="form-control form-control-border form-control-sm text-center" value="{{$lBarang->selisih}}" name="inputSelisih" id="inputSelisih" readonly>        
    </td>
    <td>
        <button type="button" class="btn btn-danger btn-sm elevation-1 btn-delete btn-flat btn-block" data-id="{{$lBarang->idm_data_product}}"><i class="fa-solid fa-xmark"></i></button>
    </td>
</tr>
@endforeach