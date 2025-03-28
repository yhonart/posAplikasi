<?php
    $totHpp = 0;
    $selisih = 0;
    $margin = 0;
    $sumHargaJual = 0;
    $sumMargin = 0;
    $sumSelisih = 0;
    $sumTotHpp = 0;
    $sumMPrice = 0;
    $sumTPrice = 0;
?>
<div class="card">
    <div class="card-header border-0">
        <div class="card-title">
            Ringkasan Laporan Produk
        </div>
    </div>
    <div class="card-body text-xs p-2 table-responsive">
        <table class="table table-sm table-valign-middle table-hover" id="labaRugiReport">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Qty</th>
                    <th class="text-right">Harga Jual</th>
                    <th class="text-right">Harga Modal</th>
                    <th class="text-right">Tot. Penj.(Rp)</th>
                    <th class="text-right">Tot. Hpp</th>
                    <th class="text-right">Laba/Rugi<br>(Selisih)</th>
                    <th class="text-right">Laba/Rugi<br>(Margin)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mProduct as $mpd)
                    <tr>
                        <td colspan="9" class="bg-gray font-weight-bold">
                            <span title="{{$mpd->product_code}}">{{$mpd->product_name}}</span>                        
                        </td>                        
                    </tr>
                    @foreach($detailItem as $dit)
                        @if($dit->product_code == $mpd->product_code)
                            <tr>
                                <td>{{$dit->product_name}}</td>
                                <td>{{$dit->unit}}</td>                                
                                <td>{{$dit->qty}}</td>                                
                                <td class="text-right">
                                    {{number_format($dit->unit_price,'0',',','.')}}
                                    @php
                                        $sumHargaJual += $dit->unit_price;
                                    @endphp
                                </td>                                
                                <td class="text-right">
                                    {{number_format($dit->m_price,'0',',','.')}}
                                    @php
                                        $sumMPrice += $dit->m_price;
                                    @endphp
                                </td>                                
                                <td class="text-right">
                                    {{number_format($dit->t_price,'0',',','.')}}
                                    @php
                                        $sumTPrice += $dit->t_price;
                                    @endphp

                                </td>                                
                                <td class="text-right">
                                    <?php
                                        $totHpp = $dit->m_price * $dit->qty;
                                        echo number_format($totHpp,'0',',','.');
                                        $sumTotHpp += $totHpp;
                                    ?>
                                </td>  
                                <td class="text-right">
                                    <?php
                                        $selisih = $dit->unit_price - $dit->m_price;
                                        echo number_format($selisih,'0',',','.');
                                        $sumSelisih  += $selisih;
                                    ?>
                                </td>                              
                                <td class="text-right">
                                    <?php
                                        $margin = $selisih * $dit->qty;
                                        echo number_format($margin,'0',',','.');
                                        $sumMargin += $margin;
                                    ?>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
            <tbody class=" bg-blue">
                <tr>
                    <td colspan="3" class="font-weight-bold">Total</td>
                    <td class=" text-right font-weight-bold">{{number_format($sumHargaJual,'0',',','.')}}</td>
                    <td class=" text-right font-weight-bold">{{number_format($sumMPrice,'0',',','.')}}</td>
                    <td class=" text-right font-weight-bold">{{number_format($sumTPrice,'0',',','.')}}</td>
                    <td class=" text-right font-weight-bold">{{number_format($sumTotHpp,'0',',','.')}}</td>
                    <td class=" text-right font-weight-bold">{{number_format($sumSelisih,'0',',','.')}}</td>
                    <td class=" text-right font-weight-bold">{{number_format($sumMargin,'0',',','.')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
// $(function () {
//     $('#labaRugiReport').DataTable({
//         "paging": true,
//         "lengthChange": true,
//         "searching": true,
//         "ordering": true,
//         "info": true,
//         "autoWidth": false,
//         "responsive": true,
//     });
// });
</script>

