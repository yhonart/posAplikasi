<div class="card card-body p-0 table-responsive">
    <table class="table table-sm table-bordered table-valign-middle">
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
            @foreach($mProduct as $mpd)
                <tr>
                    <td>{{$mpd->product_name}}</td>
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
            @endforeach
        </tbody>
    </table>
</div>

