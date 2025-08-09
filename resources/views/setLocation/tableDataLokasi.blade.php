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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>