<?php
    $nosum = '1';
    $araystatus = array(
        1=>"On Process",
        2=>"Submited",
        3=>"Approved",
        0=>"Deleted",
    );
    $textColor = array(
        1=>"text-info",
        2=>"text-warning",
        3=>"text-success",
        0=>"text-danger",
    );
?>
<table class="table table-sm table-valign-middle table-hover table-striped" id="listDocOpname">
    <thead>
        <tr>
            <th>No.</th>
            <th>Opname Number</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>User Input</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($summaryOpname as $summary)
            <tr>
                <td>{{$nosum++}}</td>
                <td>{{$summary->number_so}}</td>
                <td>{{$summary->date_so}}</td>
                <td>{{$summary->site_name}}</td>
                <td>{{$summary->created_by}}</td>
                <td class="text-right"><span class="{{$textColor[$summary->status]}} font-weight-bold">{{$araystatus[$summary->status]}}</span></td>
                <td class="text-right">
                    @if($summary->status == '2')
                        <a class="btn btn-sm btn-info elevation-1  btnEdit" title="Edit Dokumen" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-pencil"></i> Edit</a>
                    @endif
                    
                    @if($approval >= '1' AND $summary->status == '2' AND $summary->t_input_stock<>'')
                        <button type="button" class="btn btn-sm btn-success btnApprove elevation-1 " title="Approve" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-check"></i>Approve</button>
                    @endif
                    @if($approval >= '1' AND $approval >='1')
                        <button type="button" class="btn btn-sm btn-primary btnDetail elevation-1 " id="btnDetail" title="View Detail {{$summary->status}}" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-magnifying-glass"></i> Detail</button>
                    @endif
                    @if($summary->status == '2')
                        <button type="button" class="btn btn-sm btn-danger btnDelete elevation-1 " title="Delete" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-trash"></i> Delete</button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function(){
        $('#listDocOpname').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
    });
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".dataTable").on('click','.btnDetail', function () {
            var element = $(this);
            var  idparam = element.attr("data-opname");
            $.ajax({
                type:'get',
                url:"{{route('stockOpname')}}/listDataOpname/detailOpname/"+idparam,
                dataType: 'html',
                success:function(response){
                    $("#detailOpname").html(response);
                }
            });
        });
        
        $(".dataTable").on('click','.btnApprove', function () {
            var element = $(this);
            var  idparam = element.attr("data-opname");
            alertify.confirm("Apakah anda yakin ingin menyetujui dokumen "+idparam+" ?",
            function(){
                $.ajax({
                    type:'get',
                    url:"{{route('stockOpname')}}/listDataOpname/approvalOpname/"+idparam,
                    dataType: 'html',
                    success:function(response){                        
                        window.location.reload();
                    }
                });
                alertify.success('Approved');
            },
            function(){
                alertify.error('Cancel Approval');
            }).set({title:"Approval"});
        });
        
        $(".dataTable").on('click','.btnEdit', function () {
            var element = $(this);
            var  idparam = element.attr("data-opname");
            $.ajax({
                type:'get',
                url:"{{route('stockOpname')}}/listDataOpname/editOpname/"+idparam,
                dataType: 'html',
                success:function(response){
                    $("#listDocOpname").fadeOut("slow");
                    $("#detailOpname").html(response);
                }
            });
        });

        $(".dataTable").on('click','.btnDelete', function () {
            var element = $(this);
            var  idparam = element.attr("data-opname");
            alertify.confirm("Apakah anda yakin ingin menghapus transaksi ini?.",
              function(){
                $.ajax({
                    type:'get',
                    url:"{{route('stockOpname')}}/listDataOpname/deleteDataOpname/"+idparam,
                    dataType: 'html',
                    success:function(response){
                      window.location.reload();
                    }
                });
              },
              function(){
                alertify.error('Cancel');
              }).set({title:"Delete Transaksi Opname"});
        });
    });
</script>