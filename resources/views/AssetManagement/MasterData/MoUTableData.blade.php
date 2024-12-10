@php
    $no = 1;
@endphp
<table class="table table-hover table-valign-middle table-sm" id="tableDataMou">
    <thead class="bg-gray">
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
                    <button class="btn btn-info btn-sm BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('MoU')}}/tableMoU/EditMoU/{{$mou->idm_unit}}"><i class="fa-solid fa-pencil"></i> Edit</button>
                    <button class="btn btn-danger btn-sm DELETE-BTN" data-id="{{$mou->idm_unit}}" data-unit="{{$mou->unit_note}}"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function(){
        $("#tableDataMou").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $(document).ready(function(){
        $(".dataTable").on('click','.DELETE-BTN', function () {
            let el = $(this);
            let id = el.attr("data-id");
            let dataUnit = el.attr("data-unit");
            alertify.confirm("Apakah anda yakin ingin menghapus data unit "+dataUnit+" ?",
            function(){
                alertify.success('Ok');
                $.ajax({
                    type:'get',
                    url:"{{route('MoU')}}/tableMoU/DeleteMoU/" + id, 
                    success : function(response){
                        window.location.reload();
                    }           
                }); 
            },
            function(){
                alertify.error('Cancel');
            });
        });
    });
</script>