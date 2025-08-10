<?php
    $arrGroup = array(
        0=>"Unknown",
        1=>"TOKO",
        2=>"GUDANG",
    );
    $nomor = 1;
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm table-valign-middle table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Group</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dbLokasi as $lokasi)
                            <tr>
                                <td>{{$nomor++}}</td>
                                <td>{{$lokasi->site_code}}</td>
                                <td>{{$lokasi->site_name}}</td>
                                <td><b>{{$lokasi->site_city}}</b>, <small class="text-muted">{{$lokasi->site_address}}</small></td>
                                <td>{{$arrGroup[$lokasi->site_group]}}</td>
                                <td class="text-right">
                                    <button class="btn btn-warning btn-sm EDIT-LOKASI"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger btn-sm DELETE-LOKASI" data-id="{{$lokasi->idm_site}}"><i class="fa-solid fa-circle-xmark"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.DELETE-LOKASI').on('click', function (e) {
            e.preventDefault();
            let dataID = $(this).attr('data-id');
            alertify.confirm("Apakah anda yakin ingin menghapus lokasi ini ?",
            function(){
                alertify.success('Ok');
                $.ajax({
                    url: "{{route('setLokasi')}}/tableDataLokasi/DeleteTable/" + dataID,
                    type: 'GET',
                    success: function (data) {   
                        window.location.reload();                
                    },                
                });
            },
            function(){
                alertify.error('Cancel');
            }).set({title:"Konfirmasi delete lokasi"});
            
        });
    });
</script>