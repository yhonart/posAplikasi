<?php 
    // header("Content-type: application/vnd-ms-excel");
    // header("Content-Disposition: attachment; filename=Laporan Laba Rugi.xls");
    $no = '1';
    $sumTotHpp = '0';
    $sumSelisih = '0';
?>
<table border="1" cellpadding="0" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            @if(!empty($mCompany))
                <th colspan="9">{{$mCompany->company_name}}</th>
            @else
                <th colspan="9">Nama Toko</th>
            @endif
        </tr>
        <tr>
            <th colspan="9">Ringkasan Laporan Laba Rugi</th>
        </tr>
        <tr>
            <th colspan="9">Dari Tgl {{$fromDate}} s.d {{$endDate}}</th>
        </tr>
    </thead>
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
                                $sumTotHpp += $totHpp;
                            ?>
                        </td>
                        <td style="text-align: right;">
                            <?php
                                $selisih = $mpd->t_price - $totHpp;
                                echo number_format($selisih,'0',',','.');
                                // $sumSelisih += $selisih;
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
                        <td><b>SUB TOTAL</b></td>
                        <td style="text-align: right;"><b>{{number_format($sp->hargaJual,'0',',','.')}}</b></td>
                        <td style="text-align: right;"><b>{{number_format($sp->hargaModal,'0',',','.')}}</b></td>
                        <td style="text-align: right;"><b>{{number_format($sp->totalJual,'0',',','.')}}</b></td>
                        <td style="text-align: right;">
                            <b>
                                {{number_format($sumTotHpp,'0',',','.')}}
                            </b>
                        </td>
                        <td style="text-align: right;">
                            <b>
                                {{number_format($sumSelisih,'0',',','.')}}
                            </b>
                        </td>
                        <td style="text-align: right;">

                        </td>
                    </tr>
                @endif
            @endforeach       
        @endforeach
    </tbody>
</table>

