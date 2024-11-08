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
<div id="table_my_events">
    <div class="text-center LOAD-SPINNER text-sm" style="display:none;">    
        <span class="spinner-grow spinner-grow-sm" role="status"></span> Please Wait !
    </div>
    
    <div class="row mb-2">
        <div class="col-12">
            <div id="detailKoreksi"></div>
        </div>
    </div>

    <div class="card card-outline card-info table-responsive p-1">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">List Dokumen Koreksi</h3>
        </div>
        <div class="card-body">            
            <table class="table table-sm table-valign-middle table-hover" id="tableDataKoreksi">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Created By</th>
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
                                <span class="float-right {{$textColor[$ldk->status]}} font-weight-bold pl-3">
                                    {{$araystatus[$ldk->status]}}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {{$lisDatKoreksi->links()}}
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#tableDataKoreksi').DataTable({
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
        
        $(function () {
            $('.pagination a').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $('#table_my_events').load(url);
            });
        });
        
        $(".dataTable").on('click','.btnDetail', function () {
            $(".LOAD-SPINNER").fadeIn();
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