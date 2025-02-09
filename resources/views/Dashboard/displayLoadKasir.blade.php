<?php
    $sumPendapatan = 0;
?>
<div class="row">
    <div class="col-md-12">
        <a href="http://" class="btn btn-light border-0 font-weight-bold text-info">Pembayaran Piutang Pelanggan</a>
    </div>
</div>
<table class="table table-striped projects">
    <thead>
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