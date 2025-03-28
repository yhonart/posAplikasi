<?php
    $arrStatus = array(
        0=>"Dibatalkan",
        1=>"Diperiksa",
        2=>"Disetujui",
    );
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body text-xs">
            <table class="table table-sm table-valign-middle table-hover" id="tableRiwayatPengembalian">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Sumber Dana</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Nominal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tbReumbers as $tr)
                        <tr>
                            <td>{{$tr->reumbers_no}}</td>
                            <td>{{date("d-M-Y", strtotime($tr->reumbers_date))}}</td>                            
                            <td>{{$tr->from_akun}} @ {{number_format($tr->nominal_dana,'0',',','.')}}</td>
                            <td>{{$tr->description}}</td>
                            <td>
                                <span class="border border-info p-1 rounded-pill bg-light">
                                    {{$arrStatus[$tr->status]}}
                                </span>
                            </td>
                            <td>{{number_format($tr->nominal,'0',',','.')}}</td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm"><i class="fa-solid fa-magnifying-glass"></i></a>
                                @if($tr->status == '1')
                                    <a href="#" class="btn btn-success btn-sm APPROVE" data-id="{{$tr->reumbers_id}}" id="btnApprove{{$tr->reumbers_id}}"><i class="fa-solid fa-check"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){        
        $("#tableRiwayatPengembalian").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $(document).ready(function(){
        $(".dataTable").on('click','.APPROVE', function (e) {
            e.preventDefault();
            $(".LOAD-SPINNER").fadeIn();
            let dataId = $(this).attr('data-id');
            $(this).closest("tr").find("#btnApprove"+dataId).animate({ opacity: "hide" }, "slow");
            //alert(dataId);
            alertify.confirm("Apakah anda yakin akan menyetujui transaksi ini ?",
            function(){
                $.ajax({
                    type : 'get',
                    url : "{{route('trxReumbers')}}/AppoveReumbers/"+dataId,
                    success : function(response){
                        window.location.reload();
                    }
                });
            },
            function(){
                alertify.error('Cancel');
            }).set({title:"Konfirmasi Persetujuan Transaksi"});
        });
    });
</script>