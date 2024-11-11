<?php
    $noKrs = '1';
?>
@foreach($listBarang as $lbk)
    <tr>
        <td>{{$noKrs++}}</td>
        <td>{{$lbk->product_name}}</td>
        <td>{{$lbk->site_name}}</td>
        <td>{{$lbk->product_satuan}}</td>
        <td>{{$lbk->d_k}}</td>
        <td>
            <input type="text" value="{{$lbk->input_qty}}" class="form-control form-control-sm form-control-border"  onchange="saveToDatabase(this,'inv_list_correction','input_qty','{{$lbk->idinv_list}}','idinv_list')" onClick="showEdit(this);" name="editQty" id="editQty">
        </td>
        <td>
            {{$lbk->stock}}
        </td>
        <td>
            {{$lbk->qty}}
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger  elevation-1 DELETE-ITEM" data-id="{{$lbk->product_correcId}}"><i class="fa-solid fa-xmark"></i></button>
        </td>
    </tr>
@endforeach
<script>
    $(document).ready(function(){        
        $('.DELETE-ITEM').on('click', function () {
            var element = $(this);
            var  idparam = element.attr("data-id");
            alertify.confirm("Apakah anda yakin ingin menghapus item ini ?",
              function(){
                $.ajax({
                    type:'get',
                    url:"{{route('koreksiBarang')}}/deleteItem/"+idparam,
                    dataType: 'html',
                    success:function(response){
                        $("#detailOpname").html(response);
                        window.location.reload();
                    }
                });
                alertify.success('Ok');
              },
              function(){
                alertify.error('Cancel');
              }).set({title:"Hapus Item !"});
        });
    });

    function saveToDatabase(editableObj,tablename,column,id,ideqm,idprd) {
        let display = "listInputBarang";
        $(editableObj).css("background","#FFF url({{asset('public/images/loadericon.gif')}}) no-repeat right");
        $.ajax({
            url: "{{route('koreksiBarang')}}/saveToDatabase",
            type: "POST",
            data:'tableName='+tablename+'&column='+column+'&editVal='+editableObj.value+'&id='+id+'&tableId='+ideqm+'&prdId='+idprd,
            success: function(data){
                $(editableObj).css("background","#FDFDFD");
                alertify.success('Data Berhasil Dirubah');
                loadDisplay(display);
            }
        });
    }

    function loadDisplay(display){
        $.ajax({
            type : 'get',
            url : "{{route('koreksiBarang')}}/"+display,
            success : function(response){
                $('#displayOnDiv').html(response);
            }
        });
    }
</script>