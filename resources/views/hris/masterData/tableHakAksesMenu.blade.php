<div class="row">
    <div class="col-12">
        <table class="table table-sm table-hover">
            <thead class="bg-gray-dark">
                <tr>
                    <th>Menu</th>
                    <th>Sub Menu</th>
                    <th>Akses</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($hakAksesUser as $hku)
                    <tr>
                        <td><i class="{{$hku->icon}} text-info"></i> {{$hku->system_name}}</td>
                        <td><i class="fa-regular fa-folder-open text-success"></i> {{$hku->name_menu}}</td>
                        <td><i class="fa-solid fa-user-check text-success"></i> Allow</td>
                        <td class="text-right"><button class="btn btn-danger  btn-sm delete-menu" data-id="{{$hku->idusers_auth}}"><i class="fa-solid fa-xmark"></i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function () {
        $(".delete-menu").on('click', function () {
            var element = $(this);
            var  idparam = element.attr("data-id");
            alertify.confirm("Apakah anda yakin ingin menghapus akses ke menu ini ?",
              function(){
                $.ajax({
                    type:'get',
                    url:"{{route('Personalia')}}/deleteAksesMenu/"+idparam,
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