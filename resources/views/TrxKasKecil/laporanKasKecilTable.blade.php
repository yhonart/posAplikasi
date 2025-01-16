<?php
$saldoTransaksi = 0;
$debit = 0;
$kredit = 0;
?>
<a href="{{route('kasKecil')}}/cetakKasKecil/0/{{$fromDate}}/{{$endDate}}" class="btn btn-success btn-sm"><i class="fa-solid fa-file-excel"></i> Download Excel</a>
<hr>
<div class="table-responsive">
    <table class="table table-sm table-hover table-valign-mmiddle table-bordered" id="tableKasKecil">
        <thead class="bg-gray-dark">
            <tr>
                <th>Tanggal</th>
                <th>Sub.Kategori</th>
                <th>Keterangan</th>
                <th>Nomor Kendaraan</th>
                <th>User</th>
                <th>Kredit</th>
                <th>Debit</th>
                <th>Saldo</th>
                <th>Ket. Lain</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td></td>
                    <td class="font-weight-bold">SALDO AWAL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right font-weight-bold">{{number_format($mDanaTrx->nominal_dana,'0',',','.')}}</td>
                    <td class="text-right font-weight-bold"></td>
                    <td class="text-right font-weight-bold">{{number_format($mDanaTrx->nominal_dana,'0',',','.')}}</td>
                    <td></td>
                    <td></td>
                </tr>
            @foreach($tablePengeluaran as $tbPengeluaran)
                <tr>
                    <td>{{date("d-M-Y", strtotime($tbPengeluaran->kas_date))}}</td>
                    <td>{{$tbPengeluaran->cat_name}} - {{$tbPengeluaran->subcat_name}}</td>
                    <td>
                        {{$tbPengeluaran->description}}
                    </td>
                    <td>
                        {{$tbPengeluaran->no_polisi}}
                    </td>
                    <td>{{$tbPengeluaran->kas_persCode}}#{{$tbPengeluaran->kas_persName}}</td>
                    <td class="text-right">
                        {{number_format($tbPengeluaran->nominal_modal,'0',',','.')}}
                    </td>
                    <td class="text-right">{{number_format($tbPengeluaran->nominal,'0',',','.')}}</td>
                    <td class="text-right">
                        <?php
                            $debit += $tbPengeluaran->nominal;
                            $kredit += $tbPengeluaran->nominal_modal;
                            $saldoTransaksi += $mDanaTrx->nominal_dana - ($debit + $kredit);
                            echo number_format($saldoTransaksi,'0',',','.');
    
                        ?>
                    </td>
                    <td>{{$tbPengeluaran->file_name}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <th>Cari Tanggal</th>
            <th>Cari Sub.Kategori</th>
            <th>Cari Keterangan</th>
            <th>Cari No.Kendaraan</th>
            <th>Cari User</th>
            <th>Cari Kredit</th>
            <th>Cari Debit</th>
            <th>Cari Saldo</th>
            <th>Cari Keterangan</th>
            <th></th>
        </tfoot>
    </table>
</div>
<script>
     $(function(){        
        $("#tableKasKecil").DataTable({
            // "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "searching":false,
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