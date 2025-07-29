<?php
    $arrHakAkses = array(
        1=>"Admin",
        2=>"Kasir",
        3=>"Sales",
        4=>"Admin Sales",
        5=>"Kurir",
    );
    $nomor = 1;
?>
<table class="table table-sm table-valign-middle text-xs table-striped" id="tableData">
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
                <td>{{$nomor++}}</td>
                <td>{{$dbu->name}}</td>
                <td>{{$dbu->username}}</td>
                <td>{{$arrHakAkses[$dbu->hakakses]}}</td>
                <td class="text-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info font-weight-bold ACTION-MODAL BTN-OPEN-MODAL-GLOBAL-LG" href="#"><i class="fa-solid fa-note-sticky"></i> Detail</button>
                        <button type="button" class="btn btn-sm btn-info font-weight-bold ACTION-MODAL BTN-OPEN-MODAL-GLOBAL-LG" href="#"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(function () {
        $('#tableKategori').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
    });
</script>