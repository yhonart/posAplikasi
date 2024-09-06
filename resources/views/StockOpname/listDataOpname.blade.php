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
<div class="row">
    <div class="col-12">
        <div id="detailOpname"></div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-info card-outline">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">List Data Stock Opname</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-valign-middle table-hover table-striped table-bordered" id="listDocOpname">
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
                                    @if($summary->status >= '2')
                                        <a class="btn btn-sm btn-info elevation-1 rounded-0 btnEdit" title="Edit Dokumen" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-pencil"></i> Edit</a>
                                    @endif
                                    
                                    @if($approval >= '1' AND $summary->status == '2' AND $summary->t_input_stock<>'')
                                        <button type="button" class="btn btn-sm btn-success btnApprove elevation-1 rounded-0" title="Approve" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-check"></i>Approve</button>
                                    @endif
                                    @if($approval >= '1' AND $approval >='1')
                                        <button type="button" class="btn btn-sm btn-primary btnDetail elevation-1 rounded-0" id="btnDetail" title="View Detail {{$summary->status}}" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-magnifying-glass"></i> Detail</button>
                                    @endif
                                    @if($summary->status == '2')
                                        <button type="button" class="btn btn-sm btn-danger btnDelete elevation-1 rounded-0" title="Delete" data-opname="{{$summary->number_so}}"><i class="fa-solid fa-trash"></i> Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
    })
    
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(function () {
            $('.pagination a').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $('#table_my_events').load(url);
            });
        });
        
        $('.btnDetail').on('click', function () {
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
        
        $('.btnApprove').on('click', function () {
            var element = $(this);
            var  idparam = element.attr("data-opname");
            $.ajax({
                type:'get',
                url:"{{route('stockOpname')}}/listDataOpname/approvalOpname/"+idparam,
                dataType: 'html',
                success:function(response){
                    alertify
                      .alert("Apakah Anda Yakin Ingin Melakukan Approval "+idparam+" ?", function(){
                        alertify.message(idparam+' Approved');
                        window.location.reload();
                      }).set({title:"Approval"});
                }
            });
        });
        
        $('.btnEdit').on('click', function () {
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
        
        $('.btnDelete').on('click', function () {
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
              }).set({title:"Delete Data"});
        });
    });
</script>