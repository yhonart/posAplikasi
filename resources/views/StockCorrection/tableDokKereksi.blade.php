<?php
    $nosum = '1';
    $araystatus = array(
        1=>"Proses",
        2=>"Submited",
        3=>"Disetujui",
        0=>"Deleted",
    );
    $textColor = array(
        1=>"text-info",
        2=>"text-warning",
        3=>"text-success",
        0=>"text-danger",
    );
?>
<table class="table table-sm table-valign-middle table-hover " id="tableDataKoreksi">
    <thead class="bg-gray">
        <tr>
            <th>Nomor</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Created By</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>        
        @foreach($lisDatKoreksi as $ldk)
            <tr>
                <td>{{$ldk->number}}</td>
                <td>{{$ldk->dateInput}}</td>
                <td>{{$ldk->notes}}</td>
                <td>{{$ldk->created_by}}</td>
                <td class="text-right">
                    <span class="bg-light border border-1 border-info pl-2 pr-2 pt-1 pb-1 rounded-pill font-weight-bold text-xs">{{$araystatus[$ldk->status]}}</span>
                </td>
                <td class="text-right">
                    @if($ldk->status <> '0' AND $ldk->status <> '1')
                        <button type="button" class="btn btn-sm btn-primary btnDetail " id="btnDetail" title="View Detail" data-koreksi="{{$ldk->number}}"><i class="fa-solid fa-magnifying-glass"></i> Detail</button>                        
                        @if($approval >= '1' AND $ldk->status == '2')
                            <button type="button" class="btn btn-sm btn-success btnApprove " title="Approve" data-koreksi="{{$ldk->number}}"><i class="fa-solid fa-check"></i>Approve</button>
                        @endif
                        @if($approval >= '1' AND $ldk->status >= '2')
                            <!--<a class="btn btn-sm btn-info" id="btnEdit" title="Edit"><i class="fa-solid fa-pencil"></i> Edit</a>-->
                        @endif
                        @if($approval >= '1' AND $ldk->status <= '2')
                            <button type="button" class="btn btn-sm btn-danger btnDelete " title="Delete" data-koreksi="{{$ldk->number}}"><i class="fa-solid fa-trash"></i> Delete</button>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(function(){        
        $("#tableDataKoreksi").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(".dataTable").on('click','.btnDetail', function () {
            $(".LOAD-SPINNER").fadeIn();
            $("#divTabelDataKoreksi").fadeOut();
            var element = $(this);
            var  idparam = element.attr("data-koreksi");
            $.ajax({
                type:'get',
                url:"{{route('koreksiBarang')}}/listDataKoreksi/detailKoreksi/"+idparam,
                dataType: 'html',
                success:function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    $("#tableDataKoreksi").hide();
                    $("#detailKoreksi").html(response);
                }
            });
        });
        
        $(".dataTable").on('click','.btnApprove', function () {
            $(".LOAD-SPINNER").fadeIn();
            $("#divTabelDataKoreksi").fadeOut();
            var element = $(this);
            var  idparam = element.attr("data-koreksi");
            $.ajax({
                type:'get',
                url:"{{route('koreksiBarang')}}/listDataKoreksi/approvalKoreksi/"+idparam,
                dataType: 'html',
                success:function(response){
                    alertify
                    .alert("Apakah Anda Yakin Ingin Melakukan Approval "+idparam+" ?", function(){
                        alertify.message(idparam+' Approved');
                        window.location.reload();
                    }).set({title:"Approval"});
                    $(".LOAD-SPINNER").fadeOut();
                }
            });
        });
        
        $(".dataTable").on('click','.btnDelete', function () {
            var element = $(this);
            var  idparam = element.attr("data-koreksi");
            alertify.confirm("Apakah anda yakin ingin menghapus transaksi ini?.",
                function(){
                $.ajax({
                    type:'get',
                    url:"{{route('koreksiBarang')}}/listDataKoreksi/deleteKoreksi/"+idparam,
                    dataType: 'html',
                    success:function(response){
                        window.location.reload();
                    }
                });
                },
                function(){
                alertify.error('Cancel');
                }).set({title:"Delete Data"});
        });
    });
</script>