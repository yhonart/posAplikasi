<table weight="100%">
    <tbody>
        <tr>
            <td>
                <h4>TOKO LING LING</h4>
            </td>
        </tr>
        <tr>
            <td>
                Laporan Laba Rugi Ringkasan
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
            @foreach($mProduct as $mpd)
                @if($mpd->product_code == $mpd1->product_code)
                <tr>
                    <td>
                        <span title="{{$mpd->list_id}}">{{$mpd->product_name}}</span>                        
                    </td>
                    <td>{{$mpd->unit}}</td>
                    <td>{{$mpd->qty}}</td>
                    <td class="text-right">{{number_format($mpd->m_price,'0',',','.')}}</td>
                    <td class="text-right">{{number_format($mpd->capital_price,'0',',','.')}}</td>
                    <td class="text-right">{{number_format($mpd->t_price,'0',',','.')}}</td>
                    <td class="text-right">
                        <?php
                            $totHpp = $mpd->capital_price * $mpd->qty;
                            echo number_format($totHpp, '0',',','.');
                        ?>
                    </td>
                    <td class="text-right">
                        <?php
                            $selisih = $mpd->t_price - $totHpp;
                            echo number_format($selisih,'0',',','.');
                        ?>
                    </td>
                    <td>

                    </td>
                </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>

