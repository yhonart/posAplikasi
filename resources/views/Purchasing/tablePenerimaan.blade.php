<?php
$statusDokumen = array(
    0=>"Dihapus",
    1=>"Sedang Proses",
    2=>"Review",
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
                    <thead class="bg-gray-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nomor</th>
                            <th>Supplier</th>
                            <th>Belanja</th>
                            <th>Potongan</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTablePem as $ltp)                            
                            <tr>
                                <td>{{$ltp->delivery_date}}</td>
                                <td>
                                    <span class="font-weight-bold">{{$ltp->purchase_number}}</span>
                                </td>
                                <td>
                                    <a class="font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Purchasing')}}/modalSupplier/{{$ltp->supplier_id}}">
                                        {{$ltp->store_name}}
                                    </a>
                                </td>
                                <td class="text-right font-weight-bold">
                                    {{number_format($ltp->sub_total,'0',',','.')}}
                                </td>
                                <td class="text-right font-weight-bold text-danger">
                                    <?php
                                        foreach ($detailPotongan as $dp) {
                                            if ($dp->supplier_id == $ltp->supplier_id) {
                                                echo number_format($dp->NumRet,'0',',','.');
                                            }
                                        }
                                    ?>
                                </td>
                                <td class="text-right font-weight-bold">
                                    <?php
                                        foreach ($detailPotongan as $dp1) {
                                            if ($dp1->supplier_id == $ltp->supplier_id) {
                                                $total = $ltp->sub_total - $dp1->NumRet;
                                                echo number_format($total,'0',',','.');
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    @if($ltp->payment_methode <> '1' AND $ltp->payment_methode <> '2')
                                    <span class="text-danger font-weight-bold">{{$ltp->tempo}} [Hari]</span>
                                    @else
                                    <span class="text-success font-weight-bold">{{$ltp->tempo}}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <span class="bg-light border border-success pl-2 pr-2 pt-1 pb-1 rounded-pill">{{$statusDokumen[$ltp->status]}}</span>
                                </td>
                                <td class="text-right">
                                    <div class="bnt-group">
                                        @if($ltp->status =='2' AND $approval >= '1')
                                            <button class="btn btn-success btn-sm font-weight-bold BTN-APPROVE" id="purchaseApprove{{$ltp->id_purchase}}" data-number="{{$ltp->purchase_number}}" data-id="{{$ltp->id_purchase}}"><i class="fa-solid fa-check"></i> Approve</button>
                                        @endif
                                        @if($approval >= '1')
                                            <button class="btn btn-danger btn-sm font-weight-bold BTN-DELETE" data-number="{{$ltp->purchase_number}}"><i class="fa-solid fa-xmark"></i> Delete</button>
                                        @endif
                                        @if($ltp->status =='2')
                                            <button class="btn btn-info btn-sm font-weight-bold BTN-EDIT" data-number="{{$ltp->purchase_number}}"><i class="fa-solid fa-pencil"></i> Edit</button>
                                        @endif
                                        @if($ltp->status > '2')
                                            <button class="btn btn-primary font-weight-bold btn-sm  BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Purchasing')}}/modalPenerimaanPO/{{$ltp->purchase_number}}"><i class="fa-solid fa-binoculars" ></i> Detail</button>
                                        @endif
                                    </div>                                
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