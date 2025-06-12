<?php
    $no = '1';
    $hakAkses = array(
        1=>"Admin",
        2=>"Kasir",
        3=>"Sales",
        4=>"Admin Sales",
        5=>"Kurir",
        99=>"Administrator",
    );
?>
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-valign-middle table-striped " id="tablePersonalia">
                <thead>
                    <tr>
                        <td>NO.</td>
                        <td>Nama</td>
                        <td>User Name</td>
                        <td>Lokasi Kerja</td>
                        <td>Hak Akses</td>
                        <td>Toko</td>
                        <td>#</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td class="text-center">{{$no++}}</td>
                            <td>{{$u->name}}</td>
                            <td>{{$u->username}}</td>
                            <td>{{$u->site_name}}</td>
                            <td>{{$hakAkses[$u->hakakses]}}</td>
                            <td>[{{$u->company_code}}] $u->company_name</td>
                            <td class="text-right">                                
                                <a class="btn btn-sm  btn-info BTN-OPEN-MODAL-GLOBAL-LG font-weight-bold" href="{{route('Personalia')}}/modalHakAkses/{{$u->id}}"><i class="fa-solid fa-shield-halved"></i> Hak Akses</a>
                                <a class="btn btn-sm  btn-danger font-weight-bold DEL-PERSONALIA" href="#" data-id="{{$u->id}}"><i class="fa-solid fa-trash"></i> Delete</a>
                                <a class="btn btn-sm btn-success BTN-OPEN-MODAL-GLOBAL-LG font-weight-bold" href="{{route('Personalia')}}/modalEditUser/{{$u->id}}"><i class="fa-solid fa-user-pen"></i> Edit Profile</a>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#tablePersonalia').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
        
        $(".dataTable").on('click','.DEL-PERSONALIA', function () {
            var element = $(this);
            var  idparam = element.attr("data-id");
            alertify.confirm("Apakah anda yakin ingin menghapus personil ini ?",
              function(){
                $.ajax({
                    type:'get',
                    url:"{{route('Personalia')}}/delPersonalia/"+idparam,
                    success:function(response){
                        alertify.success('Data berhasil dihapus!');
                        location.reload();
                    }
                });
              },
              function(){
                alertify.error('Penghapusan dibatalkan!');
              }).set({title:"Konfirmasi Penghapusan Data !"});
        });
     });
</script>
