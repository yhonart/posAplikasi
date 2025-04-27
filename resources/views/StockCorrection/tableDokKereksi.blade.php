<?php
    $nosum = '1';
    $araystatus = array(
        1=>"Proses",
        2=>"Submited",
        3=>"Disetujui",
        0=>"Deleted",
    );
    $bgColor = array(
        1=>"bg-warning",
        2=>"bg-primary",
        3=>"bg-success",
        0=>"bg-danger",
    );
?>
<table class="table table-sm table-valign-middle table-hover " id="tableDataKoreksi">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Created By</th>
            <th class="text-right">Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>        
        @foreach($lisDatKoreksi as $ldk)
            <tr>
                <td>{{$ldk->number}}</td>
                <td>{{date("d-M-y", strtotime($ldk->dateInput))}}</td>
                <td>{{$ldk->notes}}</td>
                <td>{{$ldk->created_by}}</td>
                <td class="text-right">
                    <span class="{{$bgColor[$ldk->status]}} pl-2 pr-2 pt-1 pb-1 rounded-pill text-xs">{{$araystatus[$ldk->status]}}</span>
                </td>
                <td>
                    @if($ldk->status <> '0' AND $ldk->status <> '1')
                        @if($approval >= '1' AND $ldk->status == '2')
                            <button type="button" class="btn btn-sm btn-success btnApprove " title="Approve" data-koreksi="{{$ldk->number}}"><i class="fa-solid fa-check"></i></button>
                        @endif
                        @if($approval >= '1' AND $ldk->status <= '2')
                            <button type="button" class="btn btn-sm btn-danger btnDelete " title="Delete" data-koreksi="{{$ldk->number}}"><i class="fa-solid fa-trash"></i></button>
                        @endif
                        <button type="button" class="btn btn-sm btn-primary btnDetail " id="btnDetail" title="View Detail" data-koreksi="{{$ldk->number}}"><i class="fa-solid fa-magnifying-glass"></i></button>                        
                        @if($approval >= '1' AND $ldk->status >= '2')
                            <!--<a class="btn btn-sm btn-info" id="btnEdit" title="Edit"><i class="fa-solid fa-pencil"></i> Edit</a>-->
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right text-info" colspan="6">{{$tanggalAwal}} s.d {{$tanggalAkhir}}</th>
        </tr>
    </tfoot>
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