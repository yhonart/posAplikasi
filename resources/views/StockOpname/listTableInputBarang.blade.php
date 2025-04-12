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
        {{$lBarang->input_qty}}
    </td>
    <td>
        {{$lBarang->site_name}}
    </td>
    <td>{{$lBarang->last_stock}}</td>
    <td>
        {{$lBarang->selisih}}
    </td>
    <td>
        <button type="button" class="btn btn-danger btn-sm elevation-1  btn-delete" data-id="{{$lBarang->idm_data_product}}"><i class="fa-solid fa-xmark"></i></button>
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
    function saveToDatabase(editableObj,tablename,column,id,ideqm,idprd) {
        $(editableObj).css("background","#FFF url({{asset('public/images/loadericon.gif')}}) no-repeat right");
        $.ajax({
            url: "{{route('stockOpname')}}/saveToEditTable",
            type: "POST",
            data:'tableName='+tablename+'&column='+column+'&editVal='+editableObj.value+'&id='+id+'&tableId='+ideqm+'&prdId='+idprd,
            success: function(data){
                $(editableObj).css("background","#FDFDFD");
                alertify.success('Data Berhasil Dirubah');
                loadDisplay(loadDiv);
            }
        });
    }
    
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