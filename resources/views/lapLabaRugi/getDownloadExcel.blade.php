<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Report Laba Rugi Ringkasan.xls");
    $no = '1';
?>
<table weight="100%">
    <tbody>
        <tr>
            <td style="text-align: center;">
                <h2>TOKO LING LING</h2>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                Laporan Laba Rugi Ringkasan
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                Dari Tgl {{$fromDate}} s.d {{$endDate}}
            </td>
        </tr>
    </tbody>
</table>
<table border="1" cellpadding="0" cellspacing="0" style="width:100%">
    <thead class="bg-gradient-purple">
        <tr>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Qty</th>
            <th>Harga Jual</th>
            <th>Harga Modal</th>
            <th>Tot. Penj.(Rp)</th>
            <th>Tot. Hpp</th>
            <th>Laba/Rugi<br>(Selisih)</th>
            <th>Laba/Rugi<br>(Margin)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mProduct as $mpd1)
            <tr>
                <td colspan="9">
                    <b title="{{$mpd1->list_id}} - {{$mpd1->from_payment_code}}">{{$mpd1->product_name}}</b>                        
                </td>
            </tr>

            @foreach($tableProduct as $mpd)
                @if($mpd->product_code == $mpd1->product_code)
                    <tr>
                        <td>
                            <span>{{$mpd->product_name}}</span>                        
                        </td>

                        <td>{{$mpd->unit}}</td>
                        <td>{{$mpd->qty}}</td>
                        <td style="text-align: right;">{{number_format($mpd->m_price,'0',',','.')}}</td>
                        <td style="text-align: right;">{{number_format($mpd->capital_price,'0',',','.')}}</td>
                        <td style="text-align: right;">{{number_format($mpd->t_price,'0',',','.')}}</td>
                        <td style="text-align: right;">
                            <?php
                                $totHpp = $mpd->capital_price * $mpd->qty;
                                echo number_format($totHpp, '0',',','.');
                            ?>
                        </td>
                        <td style="text-align: right;">
                            <?php
                                $selisih = $mpd->t_price - $totHpp;
                                echo number_format($selisih,'0',',','.');
                            ?>
                        </td>
                        <td style="text-align: right;">

                        </td>
                    </tr>
                @endif
            @endforeach

            @foreach($sumPrice as $sp)
                @if($sp->product_code == $mpd1->product_code)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{$sp->qty}}</td>
                        <td style="text-align: right;">{{number_format($sp->hargaJual,'0',',','.')}}</td>
                        <td style="text-align: right;">{{number_format($sp->hargaModal,'0',',','.')}}</td>
                        <td style="text-align: right;">{{number_format($sp->totalJual,'0',',','.')}}</td>
                        <td style="text-align: right;">
                            <?php
                                $sumtotHpp = $sp->hargaModal * $sp->qty;
                                echo number_format($totHpp, '0',',','.');
                            ?>
                        </td>
                        <td style="text-align: right;">
                            <?php
                                $sumselisih = $sp->totalJual - $sumtotHpp;
                                echo number_format($sumselisih,'0',',','.');
                            ?>
                        </td>
                        <td style="text-align: right;">

                        </td>
                    </tr>
                @endif
            @endforeach

        @endforeach
    </tbody>
</table>

