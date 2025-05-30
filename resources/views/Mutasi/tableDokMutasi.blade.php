<?php
    $noMutasi = '1';
    $statusDokumen = array(
        0=>"Dihapus",
        1=>"Sedang Proses",
        2=>"Submited",
        3=>"Disetujui",
        4=>"Diterima"
    );
    $bgColor = array(
        0=>"bg-danger",
        1=>"bg-info",
        2=>"bg-primary",
        3=>"bg-warning",
        4=>"bg-success"
    );
?>
<table class="table table-sm table-valign-middle table-hover " id="tableDokMutasi">
    <thead>
        <tr>
            <th>No.</th>
            <th>No. Mutasi</th>
            <th>Tgl. Mutasi</th>
            <th>Lokasi Asal</th>
            <th>Lokasi Tujuan</th>
            <th>User Input</th>
            <th class="text-right">Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($tableMoving as $tm)
            <tr>
                <td>{{$noMutasi++}}</td>
                <td>{{$tm->number}}</td>
                <td>{{date("d-M-y", strtotime($tm->date_moving))}}</td>
                <td class="bg-success font-weight-bold">
                    @foreach($mSites as $ms1)
                        @if($ms1->idm_site == $tm->from_loc)
                            {{$ms1->site_name}}
                        @endif
                    @endforeach
                </td>
                <td class="bg-warning font-weight-bold">
                    @foreach($mSites as $ms2)
                        @if($ms2->idm_site == $tm->to_loc)
                            {{$ms2->site_name}}
                        @endif
                    @endforeach
                </td>
                <td>{{$tm->created_by}}</td>
                <td class="text-right">
                    <span class="{{$bgColor[$tm->status]}} pl-2 pr-2 pt-1 pb-1 rounded-pill text-xs">{{$statusDokumen[$tm->status]}}</span>
                </td>
                <td class="text-right">
                    @if($tm->status <> '0')
                        @if($approval >= '1' AND $tm->status == '2')
                            <button type="button" class="btn btn-sm btn-success btnApprove font-weight-bold" id="btnApprove{{$tm->idinv_moving}}" title="Kirim Barang" data-opname="{{$tm->number}}" data-id="{{$tm->idinv_moving}}"><i class="fa-solid fa-check"></i></button>
                        @endif
                        
                        <button type="button" class="btn btn-sm btn-primary btnDetail font-weight-bold" id="btnDetail" title="View Detail" data-opname="{{$tm->number}}" data-id="{{$tm->idinv_moving}}"><i class="fa-solid fa-magnifying-glass"></i></button>
                        
                        @if($tm->status == '2' AND $approval >= '1')
                            <button type="button" class="btn btn-sm btn-info btnEdit  font-weight-bold" id="btnEdit" title="Edit" data-opname="{{$tm->number}}" data-id="{{$tm->idinv_moving}}"><i class="fa-solid fa-pencil"></i></button>                        
                        @endif
                        
                        @if($tm->status >= '1' AND $tm->status <= '2')
                        <button type="button" class="btn btn-sm btn-danger btnDelete  font-weight-bold" title="Delete" data-opname="{{$tm->number}}" data-id="{{$tm->idinv_moving}}"><i class="fa-solid fa-trash"></i></button>
                        @endif                        
                    @else
                        <span class="text-danger font-weight-bold">Deleted</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="8" class="text-right font-weight-bold">{{date('d-M-Y', strtotime($tanggalAwal))}} s/d {{date('d-M-Y', strtotime($tanggalAkhir))}}</th>
        </tr>
    </tfoot>
</table>

<script>
    $(function(){
        $("#tableDokMutasi").DataTable({
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
        
        $(".dataTable").on('click','.btnApprove', function () {
            var element = $(this);
            var idparam = element.attr("data-opname");
            var dataID = element.attr("data-id");
            $(this).closest("tr").find("#btnApprove"+dataID).animate({ opacity: "hide" }, "slow");
            alertify.confirm("Apakah anda yakin dengan data item yang di mutasi ?",
              function(){
                    $.ajax({
                        type:'get',
                        url:"{{route('mutasi')}}/tableDataMutasi/pickup/"+idparam,
                        dataType: 'html',
                        success:function(response){
                            window.location.reload();
                        }
                    });
                alertify.success('Ok');
              },
              function(){
                alertify.error('Cancel');
              }).set({title:"Konfirmasi Terima Barang"});
            
        });
        
        $(".dataTable").on('click','.btnDetail', function () {
            var element = $(this);
            var  idparam = element.attr("data-opname");
            $(".LOAD-SPINNER").fadeIn();
            $("#tableDocMutasi").fadeOut();
            $.ajax({
                type:'get',
                url:"{{route('mutasi')}}/tableDataMutasi/detailMutasi/"+idparam,
                dataType: 'html',
                success:function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    // $("#tableDocMutasi").fadeIn();
                    $("#displayDetail").html(response);
                }
            });
        });
        $(".dataTable").on('click','.btnEdit', function () {
            var element = $(this);
            var  idparam = element.attr("data-opname");
            $(".LOAD-SPINNER").fadeIn();
            $("#tableDocMutasi").fadeOut();
            $.ajax({
                type:'get',
                url:"{{route('mutasi')}}/tableDataMutasi/editMutasi/"+idparam,
                dataType: 'html',
                success:function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    $("#tableDocMutasi").fadeOut("slow");
                    $("#displayDetail").html(response);
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
                    url:"{{route('mutasi')}}/tableDataMutasi/deleteMutasi/"+idparam,
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