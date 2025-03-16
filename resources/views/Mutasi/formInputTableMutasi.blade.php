<?php
    $noListMutasi = '1';
?>
@foreach($listMutasi as $lsm)
    <tr>
        <td class="text-center">{{$noListMutasi++}}</td>
        <td>{{$lsm->product_name}}</td>
        <td>{{$lsm->product_satuan}}</td>
        <td>{{$lsm->last_stock}}</td>
        <td class="p-0">
            <input type="number" name="editJumlah" id="editJumlah" value="{{$lsm->stock_taken}}" onchange="saveUpdateMutasi(this,'inv_moving_list','stock_taken','{{$lsm->idm_list}}','idm_list')" class="form-control form-control-sm " onfocus="this.select()">
            
        </td>
        <td class="p-0">
            <input type="text" name="editNote" id="editNote" value="{{$lsm->notes}}" class="form-control form-control-sm " onchange="saveUpdateMutasi(this,'inv_moving_list','notes','{{$lsm->idm_list}}','idm_list')" onfocus="this.select()">
        </td>
        <td class="p-0 ">
            <button class="btn btn-sm btn-danger DELETE-ITEM  float-right" data-id="{{$lsm->idm_list}}"><i class="fa-solid fa-circle-xmark"></i></button>
        </td>
    </tr>
@endforeach

<script>
    $(document).ready(function(){
        $('.DELETE-ITEM').on('click', function(){
            let elThis = $(this),
                data = elThis.attr("data-id");
                alertify.confirm("Apakah anda yakin ingin menghapus mutasi item ini ?",
                  function(){
                    $.ajax({
                        type : "get",
                        url : "{{route('mutasi')}}/listTableItem/deleteData/" + data,
                        success : function(response){
                            alertify.message('Data Berhasil Dihapus.');
                            loadListData();
                        }
                    });
                  },
                  function(){
                    alertify.error('Batal Menghapus Data.');
                  });
        });
    });
    
    function saveUpdateMutasi(editTableObj,tableName,column,id,colId){
        $.ajax({
            url: "{{route('mutasi')}}/listTableItem/editTable",
            type: "POST",
            data:'tablename='+tableName+'&column='+column+'&editval='+editTableObj.value+'&id='+id+'&colId='+colId,
            success: function(data){
                alertify.success('Data Berhasil Terupdate');
                loadListData();
            }
        });
    }
    
    function loadListData(){
        let noMutasi = "{{$mutasiCode}}";
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/formEntryMutasi/listBarang/"+noMutasi,
            success : function(response){
                $('#loadListMutasi').html(response);
            }
        });
    }
</script>