<?php
    $no = 1;
    $total = 0;
    $totalBayar = 0;
?>
<table class="table table-striped projects">
    <thead>
        <tr>
            <td>Tanggal</td>
            <td>Nama Supplier</td>
            <td>Total</td>
            <td>Pembayaran</td>
            <td>Voucher</td>
            <td>T.Bayar</td>
        </tr>
    </thead>
    <tbody>
        @foreach($pembelian as $datPembelian)
            <tr>
                <td>{{date('d-M-y', strtotime($datPembelian->delivery_date))}}</td>
                <td>{{$datPembelian->store_name}}</td>
                <td>{{number_format($datPembelian->sub_total,'0',',','.')}}</td>
                <td>
                    @if($datPembelian->payment_methode == '1' OR $datPembelian->payment_methode == '2')
                        {{$datPembelian->tempo}}
                    @else
                        Tempo : {{$datPembelian->tempo}} Hari.
                    @endif
                </td>
                <td>
                    {{number_format($datPembelian->total_potongan,'0',',','.')}}
                </td>
                <td>
                    <?php
                        $totalBayar = $datPembelian->sub_total - $datPembelian->total_potongan;
                    ?>
                    {{number_format($totalBayar,'0',',','.')}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>