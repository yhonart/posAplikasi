<?php
$saldoTransaksi = 0;
$debit = 0;
$kredit = 0;
?>
<a href="{{route('kasKecil')}}/cetakKasKecil/0/{{$fromDate}}/{{$endDate}}" class="btn btn-success btn-sm"><i class="fa-solid fa-file-excel"></i> Download Excel</a>
<hr>
<div class="table-responsive">
    <table class="table table-sm table-hover table-valign-mmiddle text-nowrap table-bordered" id="tableKasBesar">
        <thead class="bg-gray-dark">
            <tr>
                <td>Tanggal</td>
                <td>Keterangan</td>
                <td>Debit</td>
                <td>Kredit</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $tbPenjualan)
                <tr>
                    <td>{{date('d-M-Y', strtotime($tbPenjualan->tr_date))}}</td>
                    <td>Penjualan {{$tbPenjualan->created_by}}</td>
                    <td class="text-right">{{number_format($tbPenjualan->paymentCus,'0',',','.')}}</td>
                    <td class="text-right"></td>                    
                    <td>
                        <a href="#" class="btn btn-sm btn-info"><i class="fa-solid fa-magnifying-glass"></i></a>
                    </td>
                </tr>
            @endforeach
            @foreach($pembelian as $pmb)
                <tr>
                    <td>{{date('d-M-Y', strtotime($pmb->delivery_date))}}</td>
                    <td>Pembayaran Supplier {{$pmb->store_name}} @ {{$pmb->purchase_number}}</td>
                    <td></td>
                    <td class="text-right">{{number_format($pmb->sub_total,'0',',','.')}}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info"><i class="fa-solid fa-magnifying-glass"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(function(){        
        $("#tableKasBesar").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "searching": false,
            "paging": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>