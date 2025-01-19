<?php
$saldoTransaksi = 0;
$debit = 0;
$kredit = 0;
$saldoPenjualan = 0;
$saldoPembelian = 0;
$sumPembelian = 0;
?>
<a href="{{route('kasKecil')}}/cetakKasKecil/0/{{$fromDate}}/{{$endDate}}" class="btn btn-success btn-sm"><i class="fa-solid fa-file-excel"></i> Download Excel</a>
<hr>
<div class="table-responsive">
    <table class="table table-sm table-hover table-valign-mmiddle text-nowrap table-bordered" id="tableKasBesar">
        <thead class="bg-gray-dark">
            <tr>
                <th>Tanggal</th>
                <th>Nomor</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $tbPenjualan)
                <tr>
                    <td>{{date('d-M-Y', strtotime($tbPenjualan->date_trx))}}</td>
                    <td></td>
                    <td>
                        <a href="{{route('kasBesar')}}/detailPenjualan/{{$tbPenjualan->date_trx}}/{{$tbPenjualan->created_by}}" class="text-primary font-weight-bold">
                            Penjualan {{$tbPenjualan->created_by}}
                        </a>
                    </td>
                    <td class="text-right">{{number_format($tbPenjualan->paymentCus,'0',',','.')}}</td>
                    <td class="text-right"></td> 
                    <td class="text-right font-weight-bold">
                        <?php
                            $saldoPenjualan += $tbPenjualan->paymentCus;
                            echo number_format($saldoPenjualan,'0',',','.');
                        ?>
                    </td> 
                </tr>
            @endforeach
            @foreach($pembelian as $pmb)
                <tr>
                    <td>{{date('d-M-Y', strtotime($pmb->delivery_date))}}</td>
                    <td>{{$pmb->purchase_number}}</td>
                    <td>
                        <a href="#" class="text-primary">
                            Pembayaran {{$pmb->store_name}}
                        </a>
                    </td>
                    <td></td>
                    <td class="text-right">{{number_format($pmb->sub_total,'0',',','.')}}</td>
                    <td class="text-right font-weight-bold">
                        <?php
                            $sumPembelian += $pmb->sub_total;
                            $saldoPembelian = $saldoPenjualan - $sumPembelian;
                            echo number_format($saldoPembelian,'0',',','.');
                        ?>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Cari Tanggal</th>
                <th>Cari Nomor</th>
                <th>Cari Keterangan</th>
                <th>Cari Debit</th>
                <th>Cari Kredit</th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $(function(){        
        $("#tableKasBesar").DataTable({
            // "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "searching":false,
            "ordering":false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"],
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let title = column.footer().textContent;
        
                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        column.footer().replaceChildren(input);
        
                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>