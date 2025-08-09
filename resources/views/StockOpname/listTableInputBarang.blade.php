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
        {{$lBarang->site_name}}
    </td>
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function showEdit(editableObj) {
        $(editableObj).focus().select();
    }
    var loadDiv = "listInputBarang";
    
    $('.btn-delete').on('click', function () {
        var element = $(this);
        var  idparam = element.attr("data-id");
        
        $.ajax({
            type:'get',
            url:"{{route('stockOpname')}}/listInputBarang/deleteBarang/"+idparam,
            success:function(response){
                loadDisplay(loadDiv);
            }
        });
    });

    function saveToDatabase(editableObj,id,idChange) {
        $("#notifLoading").fadeIn("slow");
        $.ajax({
            url: "{{route('stockOpname')}}/listInputBarang/liveEditTable",
            type: "POST",
            data:'&editval='+editableObj.value+'&id='+id+'&idChange='+idChange,            
            success: function(data){
                $("#notifLoading").fadeOut("slow");
                alertify.success('Data Berhasil Terupdate');
                loadListData();
            }
        });
    }

    function loadListData(){
        let noOpname = $("#opnameNumber").val(),
            codeDisplay = '1';
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/listInputBarang/listBarang/"+noOpname+"/"+codeDisplay,
            success : function(response){
                $('#listOpnamePrd').html(response);
            }
        });
    }
    
    function loadDisplay(loadDiv){
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/"+loadDiv,
            success : function(response){
                $('#displayOpname').html(response);
            }
        });
    } 

    
</script>