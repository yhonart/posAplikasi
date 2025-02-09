<?php
    $sumPendapatan = 0;
?>
<table class="table text-nowrap table-hover table-valign-middle table-sm">
    <thead class="font-weight-bold">
        <tr>
            <th>Tanggal</th>
            <th>Nama Kasir</th>
            <th>Total Penerimaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penjualan as $p)
            <tr>
                <td>{{date("d-M-y", strtotime($p->date_trx))}}</td>
                <td>{{$p->created_by}}</td>
                <td class="text-right">{{number_format($p->paymentCus,'0',',','.')}}</td>
            </tr>
            <?php
                $sumPendapatan +=$p->paymentCus
            ?>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td class="font-weight-bold text-right">{{number_format($sumPendapatan,'0',',','.')}}</td>
        </tr>
    </tbody>
</table> 