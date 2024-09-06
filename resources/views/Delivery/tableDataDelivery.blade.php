<?php
    $no = '1';
    $araystatus = array(
        1=>"Active",
        2=>"Not Active"
    );
?>
<div class="card card-body table-responsive">
    <table class="table table-sm table-valign-middle table-hover">
        <thead class="bg-purple">
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($listDelivery as $lD)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$lD->delivery_code}}</td>
                    <td>{{$lD->delivery_name}}</td>
                    <td>{{$araystatus[$lD->status]}}</td>
                    <td class="text-right">
                        <div class="btn-group">
                            <button type="button btn-sm" class="btn btn-default" data-toggle="dropdown">
                                <i class="fa-solid fa-bars"></i>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Delivery')}}/tableDataDelivery/editMenu/{{$lD->idm_delivery}}">Edit</a>
                                <a class="dropdown-item DELETE-ITEM" href="#" id-del="{{$lD->idm_delivery}}" id-name="{{$lD->delivery_name}}">Delete (Permanently)</a> 
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        $('.DELETE-ITEM').on('click',function (){
            let el = $(this);
            let id = el.attr("id-del"),
                name = el.attr("id-name");
            alertify.confirm("Apakah anda yakin ingin menghapus akun : "+name,
              function(){
                    $.ajax({
                        type:'get',
                        url:"{{route('Delivery')}}/tableDataDelivery/deleteMenu/" + id, 
                        success : function(response){
                            displaySuccess();
                            alertify.success('Akun '+name+' berhasil dihapus');
                        }           
                    });
              },
              function(){
                alertify.error('Cancel');
              }).set({title:"Konfirmasi Hapus Akun"});
                        
        });
        function displaySuccess(){
            $.ajax({
                type : 'get',
                url : "{{route('Delivery')}}/tableDataDelivery",
                success : function(response){
                    $('#displayDelivery').html(response);
                }
            });
        }
    })
</script>