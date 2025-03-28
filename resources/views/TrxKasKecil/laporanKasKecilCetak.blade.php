<?php
$saldoTransaksi = 0;
$debit = 0;
$kredit = 0;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=LaporanKasKecil".$fromDate."_".$endDate.".xls");
?>

<table border="1" cellpadding="0" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <td>Tanggal</td>
            <td>Sub.Kategori</td>
            <td>Keterangan</td>
            <td>User</td>
            <td>Kredit</td>
            <td>Debit</td>
            <td>Saldo</td>
            <td>Ket. Lain</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td></td>
                <td class="font-weight-bold">SALDO AWAL</td>
                <td></td>
                <td></td>
                <td class="text-right font-weight-bold">{{number_format($mDanaTrx->nominal_dana,'0',',','.')}}</td>
                <td class="text-right font-weight-bold"></td>
                <td class="text-right font-weight-bold">{{number_format($mDanaTrx->nominal_dana,'0',',','.')}}</td>
                <td></td>
            </tr>
        @foreach($tablePengeluaran as $tbPengeluaran)
            <tr>
                <td>{{date("d-M-Y", strtotime($tbPengeluaran->kas_date))}}</td>
                <td>{{$tbPengeluaran->cat_name}} - {{$tbPengeluaran->subcat_name}}</td>
                <td>{{$tbPengeluaran->description}}</td>
                <td>{{$tbPengeluaran->kas_persCode}}#{{$tbPengeluaran->kas_persName}}</td>
                <td class="text-right"></td>
                <td class="text-right">{{number_format($tbPengeluaran->nominal,'0',',','.')}}</td>
                <td class="text-right">
                    <?php
                        $debit += $tbPengeluaran->nominal;
                        $saldoTransaksi = $mDanaTrx->nominal_dana - $debit;
                        echo number_format($saldoTransaksi,'0',',','.');

                    ?>
                </td>
                <td>{{$tbPengeluaran->file_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>