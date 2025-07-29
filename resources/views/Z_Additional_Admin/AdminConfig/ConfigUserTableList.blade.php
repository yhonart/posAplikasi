<?php
    $arrHakAkses = array(
        1=>"Admin",
        2=>"Kasir",
        3=>"Sales",
        4=>"Admin Sales",
        5=>"Kurir",
    );
?>
<table class="table table-sm table-valign-middle text-xs">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>UserName</th>
            <th>Hak Akses</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($dbUsers as $dbu)
            <tr>
                <td></td>
                <td>{{$dbu->name}}</td>
                <td>{{$dbu->username}}</td>
                <td>{{$arrHakAkses[$dbu->hakakses]}}</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info font-weight-bold ACTION-MODAL BTN-OPEN-MODAL-GLOBAL-LG" href="#">Detail</button>
                        <button type="button" class="btn btn-sm btn-info font-weight-bold ACTION-MODAL BTN-OPEN-MODAL-GLOBAL-LG" href="#">Edit</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>