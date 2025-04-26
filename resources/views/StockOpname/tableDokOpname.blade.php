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
    $bgColor = array(
        1=>"bg-warning",
        2=>"bg-primary",
        3=>"bg-success",
        0=>"bg-danger",
    );
?>
<table class="table table-sm table-valign-middle table-hover" id="listDocOpname">
    <thead>
        <tr>
            <th>No. Dokumen</th>
            <th>Tanggal</th>
            <th>User Input</th>
            <th>Keterangan</th>
            <th class="text-right">Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($summaryOpname as $summary)
            <tr>                
                <td class=" font-weight-bold">{{$summary->number_so}}</td>
                <td>{{date("d-M-y",strtotime($summary->date_so))}}</td>
                <td>{{$summary->created_by}}</td>
                <td>{{$summary->description}}</td>
                <td class="text-right">   
                    <span class="{{$bgColor[$summary->status]}} pl-2 pr-2 pt-1 pb-1 rounded-pill text-xs">{{$araystatus[$summary->status]}}</span>                    
                </td>
                <td class="text-right">
                    @if($approval >= '1' AND $summary->status == '2' AND $summary->t_input_stock<>'')
                        <button type="button" class="btn btn-sm btn-success btnApprove elevation-1 " title="Approve" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-check"></i></button>
                    @endif    
                    @if($summary->status == '2')
                        <button type="button" class="btn btn-sm btn-danger btnDelete elevation-1 " title="Delete" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-xmark"></i></button>
                    @endif
                    @if($summary->status == '2')
                        <a class="btn btn-sm btn-info elevation-1  btnEdit" title="Edit Dokumen" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-pencil"></i></a>
                    @endif
                    @if($approval >= '1' AND $approval >='1')
                        <button type="button" class="btn btn-sm btn-primary btnDetail elevation-1 " id="btnDetail" title="View Detail" data-opname="{{$summary->number_so}}">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<p class=" bg-blue p-2">
    * Data yang di tampilkan secara default berdasarkan data dalam satu bulan yang sama ! 
</p>
<script>
    $(function(){
        $("#listDocOpname").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
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
            var element = $(this);
            var  idparam = element.attr("data-opname");
            $("#divTableOpname").fadeOut();
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
            $("#divTableOpname").fadeOut();
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