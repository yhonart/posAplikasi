@foreach($dataEditUnit as $deu)
    <tr>
        <td contenteditable="true" onBlur="saveToDatabase(this,'m_product_unit','set_barcode','{{$deu->idm_product_satuan}}','idm_product_satuan')" onClick="showEdit(this);">{{$deu->set_barcode}}</td>
        <td>
            <select name="onChangeSize" id="onChangeSize" class="custom-select form-control-border" onchange="saveToDatabase(this,'m_product_unit','product_size','{{$deu->idm_product_satuan}}','idm_product_satuan')">
                <option value="{{$deu->product_size}}">{{$deu->product_size}}</option>
            </select>            
        </td>
        <td>
            <select name="onChangeSize" id="onChangeSize" class="custom-select form-control-border" onchange="saveToDatabase(this,'m_product_unit','product_satuan','{{$deu->idm_product_satuan}}','idm_product_satuan')">
                <option value="{{$deu->product_satuan}}">{{$deu->product_satuan}}</option>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //Edit Table
    function showEdit(editTableObj) {
        $(editTableObj).css("background","#f0abfc");        
    }

    function saveToDatabase(editTableObj,tableName,column,id,tableId) {
        $(editTableObj).css("background","#FFF");
        $.ajax({
            url: "{{route('home')}}/GlobalLiveEditTable",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.innerHTML+'&id='+id+'&tableId='+tableId,
            success: function(data){
                $(editTableObj).css("background","#FDFDFD");
            }
        });
    } 
</script>