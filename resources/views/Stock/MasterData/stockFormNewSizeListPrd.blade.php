<?php
    $size = array(
        'Besar',
        'Kecil',
        'Terkecil'
    );
    $noList = '1';
?>
@foreach($listSizePrd as $deu)
<tr>
    <td>{{$noList++}}</td>
    <td contenteditable="true" onBlur="saveToDatabase(this,'m_product_unit','set_barcode','{{$deu->idm_product_satuan}}','idm_product_satuan')" onClick="showEdit(this);">{{$deu->set_barcode}}</td>
    <td>
        <select name="onChangeSize" id="onChangeSize" class="custom-select form-control-border" onchange="saveToDatabase(this,'m_product_unit','product_size','{{$deu->idm_product_satuan}}','idm_product_satuan')">
            <option value="{{$deu->product_size}}">{{$deu->product_size}}</option>
            @foreach($listSize as $lS)
                @if($lS->size_name <> $deu->product_size)
                    <option value="{{$lS->size_name}}">{{$lS->size_name}}</option>
                @endif
            @endforeach
        </select>            
    </td>
    <td>
        <select name="onChangeSize" id="onChangeSize" class="custom-select form-control-border" onchange="saveToDatabase(this,'m_product_unit','product_satuan','{{$deu->idm_product_satuan}}','idm_product_satuan')">
            <option value="{{$deu->product_satuan}}">{{$deu->product_satuan}}</option>
            @foreach($listUnit as $lU)
                @if($deu->product_satuan<>$lU->unit_note)
                <option value="{{$lU->unit_note}}">{{$lU->unit_note}}</option>
                @endif
            @endforeach
        </select>
    </td>
    <td contenteditable="true" onBlur="saveToDatabase(this,'m_product_unit','product_volume','{{$deu->idm_product_satuan}}','idm_product_satuan')" onClick="showEdit(this);">{{$deu->product_volume}}</td>
    <td contenteditable="true" onBlur="saveToDatabase(this,'m_product_unit','product_price_order','{{$deu->idm_product_satuan}}','idm_product_satuan')" onClick="showEdit(this);">{{$deu->product_price_order}}</td>
    <td>
        <button type="button" class="btn btn-danger DELETE-PRICE-SIZE" data-id="{{$deu->idm_product_satuan}}" data-tb="m_product_unit" data-col="idm_product_satuan"><i class="fa-solid fa-xmark"></i></button>
    </td>
</tr>
@endforeach

<script>
    $(".DELETE-PRICE-SIZE").on('click', function(e){
        e.preventDefault();
        let dataId = $(this).attr('data-id'),
            dataTb = $(this).attr('data-tb'),
            dataCol = $(this).attr('data-col'),
            dataIdProd = "{{$dataIdProd}}";

        $.ajax({
            url : "{{route('home')}}/GetGlobaDelete/WithDeleteId/"+dataId+"/"+dataTb+"/"+dataCol,
            type : 'GET',
            success : function (response) {
                dataTableSize(dataIdProd)
            }
        })
    });
</script>
