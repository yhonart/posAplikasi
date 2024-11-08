@php
    $no = 1;
@endphp
<table class="table table-striped table-valign-middle table-sm" id="tableMou">
    <thead class="bg-purple text-center">
        <tr>
            <th>No.</th>
            <th>Inisial</th>
            <th>Satuan</th>
            <th><i class="fa-solid fa-bars"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($mouData as $mou)
            <tr>
                <td class="text-center">{{$no++}}</td>
                <td>{{$mou->unit_initial}}</td>
                <td>{{$mou->unit_note}}</td>
                <td class="text-right">
                    <a class="btn btn-info  btn-sm BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('MoU')}}/tableMoU/EditMoU/{{$mou->idm_unit}}"><i class="fa-solid fa-pencil"></i> Edit Unit</a>                                    
                    <a class="btn btn-info  btn-sm BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('MoU')}}/tableMoU/DeleteMoU/{{$mou->idm_unit}}"><i class="fa-solid fa-trash-can"></i> Delete Permanently</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function () {
        $('#tableMou').DataTable({
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