<?php
    $size = array(
        'Besar',
        'Kecil',
        'Terkecil'
    );
    $noList = '1';
?>
@foreach($listSizePrd as $deu)
@php
    if($deu->product_size=="KONV"){
        $disabled = "disabled";
    }
    else{
        $disabled = "";
    }

@endphp
<tr>
    <td class="border p-0">
        <select name="onChangeSize" id="onChangeSize" class="form-control form-control-sm rounded-0" onchange="saveToDatabase(this,'m_product_unit','product_size','{{$deu->idm_product_satuan}}','idm_product_satuan','{{$deu->core_id_product}}')" {{$disabled}}>
            <option value="{{$deu->product_size}}">{{$deu->product_size}}</option>
            @foreach($listSize as $lS)
                @if($lS->size_name <> $deu->product_size)
                    <option value="{{$lS->size_name}}">{{$lS->size_name}}</option>
                @endif
            @endforeach
        </select>            
    </td>
    <td class="border p-0">
        <select name="onChangeSize" id="onChangeSize" class="form-control form-control-sm rounded-0" onchange="saveToDatabase(this,'m_product_unit','product_satuan','{{$deu->idm_product_satuan}}','idm_product_satuan','{{$deu->core_id_product}}')">
            <option value="{{$deu->product_satuan}}">{{$deu->product_satuan}}</option>
            @foreach($listUnit as $lU)
                @if($deu->product_satuan<>$lU->unit_note)
                <option value="{{$lU->unit_note}}">{{$lU->unit_note}}</option>
                @endif
            @endforeach
        </select>
    </td>
    <td class="border p-0">
        <input type="text" onchange="saveToDatabase(this,'m_product_unit','product_volume','{{$deu->idm_product_satuan}}','idm_product_satuan','{{$deu->core_id_product}}')" value="{{$deu->product_volume}}" class="form-control form-control-sm rounded-0">
    </td>
    <td class="border p-0">
        <input type="text" onchange="saveToDatabase(this,'m_product_unit','set_barcode','{{$deu->idm_product_satuan}}','idm_product_satuan','{{$deu->core_id_product}}')" value="{{$deu->set_barcode}}" class="form-control form-control-sm rounded-0">
    </td>
    <td class="p-0">
        <button type="button" class="btn btn-sm btn-danger DELETE-PRICE-SIZE float-right" data-id="{{$deu->idm_product_satuan}}" data-tb="{{$deu->core_id_product}}"><i class="fa-solid fa-xmark"></i></button>
    </td>
</tr>
@endforeach

<script>
    $(".DELETE-PRICE-SIZE").on('click', function(e){
        e.preventDefault();
        let dataId = $(this).attr('data-id'),
            dataTb = $(this).attr('data-tb'),
            dataIdProd = "{{$idPrd}}";

        $.ajax({
            url : "{{route('Stock')}}/ProductMaintenance/deleteUnit/"+dataId,
            type : 'GET',
            success : function (response) {
                displayLoadData(dataTb)
            }
        })
    });
    
    function saveToDatabase(editTableObj,tableName,column,id,tableID,idProd) {
        $.ajax({
            url: "{{route('Stock')}}/ProductMaintenance/postEditProduct",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.value+'&id='+id+'&tableID='+tableID+'&idProd='+idProd,
            success: function(data){
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil disimpan'
                })
            }
        });
    } 
    function displayLoadData(id){        
        $.ajax({
            type : 'get',
            url : "{{route('Stock')}}/AddProduct/sizeProductInput/"+id,
            success : function(response){
                $("#displayTableVolume").html(response);
            }
        });
    }
</script>
