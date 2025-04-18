<?php
    $saldoTransaksi = 0;
    $debit = 0;
    $kredit = 0;

    $lastWeekSumDebit = $trxKasKecil->nominal;

    if (empty($mDanaTrx)) {
        $lastWeekSumModal = $mTrxKas->nominal_dana;
    }
    else {
        $lastWeekSumModal = $mTrxKas->nominal_dana + $mDanaTrx->nominal_modal;        
    }
    
    $lastWeekSaldo = $lastWeekSumModal - $lastWeekSumDebit;
    $todayIs = date("l");
?>
<div class="row">
    <div class="col-md-12">

        <div class="table-responsive">
            <table class="table table-sm table-hover table-valign-middle table-striped" id="tableKasKecil">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Sub.Kategori</th>
                        <th>Keterangan</th>
                        <th>No.Kendaraan</th>
                        <th>User</th>
                        <th>Kredit</th>
                        <th>Debit</th>
                        <th>Saldo</th>
                        <th>Ket. Lain</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="font-weight-bold">
                            Saldo Awal
                        </td>
                        <td></td>
                        <td></td>
                        <td class="text-right font-weight-bold">                        
                            {{number_format($lastWeekSaldo,'0',',','.')}}
                        </td>
                        <td class="text-right font-weight-bold"></td>
                        <td class="text-right font-weight-bold">                        
                            {{number_format($lastWeekSaldo,'0',',','.')}}
                        </td>
                        <td></td>
                    </tr>
                    @foreach($tablePengeluaran as $tbPengeluaran)
                        <tr>
                            <td>{{date("d-M-y", strtotime($tbPengeluaran->kas_date))}}</td>
                            <td>
                                {{$tbPengeluaran->cat_name}}
                                <br>
                                <small>
                                    {{$tbPengeluaran->subcat_name}}
                                </small>                        
                            </td>
                            <td>
                                @if($tbPengeluaran->trx_code == 2)
                                    {{$tbPengeluaran->description}}
                                @elseif($tbPengeluaran->trx_code == 1)
                                    Reimbursement Kas
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{$tbPengeluaran->no_polisi}}
                            </td>
                            <td>{{$tbPengeluaran->kas_persName}}</td>
                            <td class="text-right font-weight-bold">
                                {{number_format($tbPengeluaran->nominal_modal,'0',',','.')}}
                            </td>
                            <td class="text-right">{{number_format($tbPengeluaran->nominal,'0',',','.')}}</td>
                            <td class="text-right font-weight-bold">
                                <?php
                                    $debit += $tbPengeluaran->nominal;
                                    $kredit += $tbPengeluaran->nominal_modal;
                                    $saldoTransaksi = $lastWeekSaldo - $debit;
                                    $nextSaldo = $saldoTransaksi + $kredit;
                                    echo number_format($nextSaldo,'0',',','.');    
                                ?>
                            </td>
                            <td>{{$tbPengeluaran->file_name}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <!-- <tfoot>
                    <th>Cari Tanggal</th>
                    <th>Cari Sub.Kategori</th>
                    <th>Cari Keterangan</th>
                    <th>Cari No.Kendaraan</th>
                    <th>Cari User</th>
                    <th>Cari Kredit</th>
                    <th>Cari Debit</th>
                    <th>Cari Saldo</th>
                    <th>Cari Keterangan</th>
                </tfoot> -->
            </table>
        </div>
    </div>
</div>
<script>
     $(function(){        
        $("#tableKasKecil").DataTable({
            // "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "searching":true,
            "buttons": ["copy", "csv", "excel", "pdf", "print"],
            // initComplete: function () {
            //     this.api()
            //         .columns()
            //         .every(function () {
            //             let column = this;
            //             let title = column.footer().textContent;
        
            //             // Create input element
            //             let input = document.createElement('input');
            //             input.placeholder = title;
            //             column.footer().replaceChildren(input);
        
            //             // Event listener for user input
            //             input.addEventListener('keyup', () => {
            //                 if (column.search() !== this.value) {
            //                     column.search(input.value).draw();
            //                 }
            //             });
            //         });
            // }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>