<?php
    $no = '1';
?>
<table class="table table-sm table-valign-middle table-hover">
    <thead class="bg-gray">
        <tr>
            <th>No</th>
            <th>User Kasir</th>
            <th>Nominal</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tbKasKasir as $tkk)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$tkk->name}}</td>
                <td>Rp. {{number_format($tkk->nominal,'0',',','.')}}</td>
                <td class="text-right">
                    <button type="button" class="btn btn-sm btn-info  BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('setKasKasir')}}/editKasKasir/{{$tkk->idm_kas}}">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger  DEL-KAS" data-id="{{$tkk->idm_kas}}">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $('.DEL-KAS').on('click', function () {
            let el = $(this);
            let dataID = el.attr('data-id');
            alertify.confirm("Apakah anda yakin ingin menghapus data ini ?",
            function(){
                $.ajax({
                    url: "{{route('setKasKasir')}}/deleteKasKasir/"+dataID,
                    type: 'GET',
                    success: function (data) {   
                        alertify.success('Ok');
                        window.location.reload();                
                    },                
                });
            },
            function(){
                alertify.error('Cancel');
            }).set({title:"Delete Kas Kasir!"});
        });
    });
</script>