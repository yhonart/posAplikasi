<?php
$saldoTransaksi = 0;
$debit = 0;
$kredit = 0;
?>
<a href="{{route('kasKecil')}}/cetakKasKecil/0/{{$fromDate}}/{{$endDate}}" class="btn btn-success btn-sm"><i class="fa-solid fa-file-excel"></i> Download Excel</a>
<hr>
<div class="table-responsive">
    <table class="table table-sm table-hover table-valign-mmiddle text-nowrap table-bordered">
        <thead class="bg-gray-dark">
            <tr>
                <td>Tanggal</td>
                <td>Keterangan</td>
                <td>Debit</td>
                <td>Kredit</td>
                <td>Saldo</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $tbPengeluaran)
                <tr>
                    <td>{{date("d-M-Y", strtotime($tbPengeluaran->date_trx))}}</td>
                    <td>Penjualan {{$tbPengeluaran->created_by}}</td>
                    <td class="text-right">{{number_format($tbPengeluaran->payment,'0',',','.')}}</td>
                    <td class="text-right"></td>
                    <td class="text-right">
                        <?php
                            $debit += $tbPengeluaran->payment;
                            // $saldoTransaksi = $mDanaTrx->nominal_dana - $debit;
                            echo number_format($debit,'0',',','.');
    
                        ?>
                    </td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>