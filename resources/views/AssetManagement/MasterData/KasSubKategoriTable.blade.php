<?php
    $status2 = array(
        0=>"Tidak Aktif",
        1=>"Aktif",
    );

    $lampiran = array(
        0=>"Tidak",
        1=>"Ya",
    );

    $noSub = '1';
?>
<table class="table table-sm table-valign-middle table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Sub Kategori</th>
            <th>Kategori</th>
            <th>Lampiran</th>
            <th>Status</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @foreach($loadSubKategori as $lsk)
            <tr>
                <td>{{$noSub++}}</td>
                <td>{{$lsk->subcat_name}}</td>
                <td>{{$lsk->cat_name}}</td>
                <td>
                    {{$lampiran[$lsk->lampiran]}}
                </td>
                <td>
                    {{$status2[$lsk->status]}}
                </td>
                <td>
                    <button class="btn btn-sm btn-info edit-sub-kategori" data-id="{{$lsk->idm_sub}}"><i class="fa-solid fa-pencil"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>