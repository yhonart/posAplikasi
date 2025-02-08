<?php

use Termwind\Components\Span;

$statusDokumen = array(
    0=>"Dihapus",
    1=>"Sedang Proses",
    2=>"Diperiksa",
    3=>"Disetujui"
);
$total = 0;
// $potonganBayar = 0;
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-2 table-responsive" style="height:700px;">
                <table class="table table-sm table-valign-middle table-hover" id="tableListPembelian">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nomor</th>
                            <th>Supplier</th>
                            <th>Belanja</th>
                            <th class="text-right">Potongan</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Pembayaran</th>
                            <th class="text-right">Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTablePem as $ltp)                            
                            <tr>
                                <td>{{$ltp->delivery_date}}</td>
                                <td>
                                    <a href="{{route('Purchasing')}}/modalPenerimaanPO/{{$ltp->purchase_number}}" class="font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG">
                                        <i class="fa-solid fa-binoculars" ></i> {{$ltp->purchase_number}}
                                    </a>
                                </td>
                                <td>
                                    {{$ltp->store_name}}
                                </td>
                                <td class="text-right font-weight-bold">
                                    {{number_format($ltp->sub_total,'0',',','.')}}
                                </td>
                                <td class="text-right font-weight-bold text-danger">
                                    <?php
                                        foreach ($detailPotongan as $dp) {
                                            if ($dp->supplier_id == $ltp->supplier_id && $ltp->voucher == '0') {
                                                // echo number_format($dp->NumRet,'0',',','.');
                                                echo "<button class='btn btn-sm btn-light BTN-OPEN-MODAL-GLOBAL-LG font-weight-bold' href='".route('Purchasing')."/modalVoucher/".$ltp->supplier_id."/".$ltp->purchase_number."' ><i class='fa-solid fa-ticket'></i> Voucher</button>";
                                            }
                                        }
                                        if ($ltp->voucher == '1') {
                                            echo number_format($ltp->total_potongan,'0',',','.');
                                        }
                                    ?>
                                </td>
                                <td class="text-right font-weight-bold">                                    
                                    <?php                                        
                                        if ($ltp->voucher == '1') {
                                            $totalBayar = $ltp->sub_total - $ltp->total_potongan;
                                            echo "<span class='text-success font-weight-bold'>".number_format($totalBayar,'0',',','.')."</span>";
                                        }
                                        else {
                                            echo "0";
                                        }
                                    ?>
                                </td>
                                <td class="text-right">
                                    @if($ltp->payment_methode <> '1' AND $ltp->payment_methode <> '2')
                                    <span class="text-danger font-weight-bold">{{$ltp->tempo}} [Hari]</span>
                                    @else
                                    <span class="text-success font-weight-bold">{{$ltp->tempo}}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-warning">{{$statusDokumen[$ltp->status]}}</span>
                                </td>
                                <td class="text-right">
                                    @if($ltp->status =='2' AND $approval >= '1')
                                        <button class="btn btn-success btn-sm font-weight-bold BTN-APPROVE" id="purchaseApprove{{$ltp->id_purchase}}" data-number="{{$ltp->purchase_number}}" data-id="{{$ltp->id_purchase}}" title="Setujui"><i class="fa-solid fa-circle-check"></i></button>
                                    @endif
                                    @if($approval >= '1')
                                        <button class="btn btn-danger btn-sm font-weight-bold BTN-DELETE" data-number="{{$ltp->purchase_number}}" title="Hapus Item"><i class="fa-solid fa-circle-xmark"></i></button>
                                    @endif
                                    @if($ltp->status =='2')
                                        <button class="btn btn-info btn-sm font-weight-bold BTN-EDIT" data-number="{{$ltp->purchase_number}}" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                    @endif
                                        <button class="btn btn-warning btn-sm font-weight-bold CETAK" data-number="{{$ltp->purchase_number}}" title="Cetak Transaksi"><i class="fa-solid fa-print"></i></button>
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
        $("#tableListPembelian").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(document).ready(function(){
        $(".dataTable").on('click','.BTN-EDIT', function (e) {
            e.preventDefault();
            $(".LOAD-SPINNER").fadeIn();
            let dataEdit = $(this).attr('data-number');
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/tablePenerimaan/editTable/"+dataEdit,
                success : function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    $("#divPageProduct").html(response);
                }
            });
        });
        
        $(".dataTable").on('click','.BTN-APPROVE', function (e) {
            e.preventDefault();
            let dataEdit = $(this).attr('data-number');
            let dataID = $(this).attr('data-id');
            $(this).closest("tr").find("#purchaseApprove"+dataID).animate({ opacity: "hide" }, "slow");
            alertify.confirm("Apakah anda yakin ingin menyetuji transaksi ini ?",
            function(){
                $.ajax({
                    type : 'get',
                    url : "{{route('Purchasing')}}/tablePenerimaan/btnApprove/"+dataEdit,
                    success : function(response){
                        window.location.reload();
                    }
                });
            },
            function(){
                alertify.error('Persetujuan dibatalkan');
            }).set({title:"Konfirmasi Persetujuan Transaksi"});
        });

        $(".dataTable").on('click','.BTN-DELETE', function (e) {
            e.preventDefault();
            let dataEdit = $(this).attr('data-number');
            alertify.confirm("Apakah anda yakin ingin menghapus transaksi " + dataEdit + " ?",
            function(){
                $.ajax({
                    type : 'get',
                    url : "{{route('Purchasing')}}/tablePenerimaan/btnDelete/"+dataEdit,
                    success : function(response){
                        loadDisplay();
                    }
                });
            },
            function(){
                alertify.error('Penghapusan data dibatalkan');
            }).set({title:"Konfirmasi Delete Transaksi"});
        });
        
        $(".dataTable").on('click','.BTN-DETAIL', function (e) {
            e.preventDefault();
            alertify
              .alert("Oppss, Menu ini belum tersedia !.", function(){
                alertify.message('OK');
              });
        });

        function loadDisplay(){
            let fromDate = "{{$fromDate}}",
                endDate = "{{$endDate}}",
                status = "{{$status}}";

            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/tablePenerimaan/"+status+"/"+fromDate+"/"+endDate,
                success : function(response){
                    $('#custom-purchase-data').html(response);
                }
            });
        }

    });
</script>