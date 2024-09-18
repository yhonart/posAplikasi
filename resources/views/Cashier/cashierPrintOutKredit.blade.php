<html>
    <head>
        <title>Cetak Nota</title>
        <link rel="stylesheet" href="{{asset('public/css/print.css')}}">
    </head>
    <body class="struk" onload="printOut()">
        <section class="sheet">
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>
                        @if(!empty($companyName))
                            {{$companyName->company_name}}
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php
                echo (str_repeat("=", 40)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>No {{$trStore->billing_number}}</td>
                        <td>{{date('d/m/Y', strtotime($trStore->tr_date))}}</td>
                    </tr>
                    <tr>
                        <td>Cus:{{$trStore->customer_name}}</td>
                        <td>Ksr:{{$trStore->created_by}}</td>
                    </tr>
                    <tr>
                        <td>Kirim:{{$trStore->tr_delivery}}</td>
                        <td>{{date("H:i:s",strtotime($trStore->created_date))}}</td>
                    </tr>
                </tbody>                
            </table>
            <?php
                echo (str_repeat("=", 40)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th align="left" class="txt-left">Item</th>
                        <th align="left" class="txt-left">Harga</th>
                        <th align="left" class="txt-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trStoreList as $tSL)
                        <tr>
                            <td>
                                {{$tSL->product_name}}
                            </td>
                        </tr>
                        <tr>
                            <td class="txt-left" align="left">{{$tSL->qty}} {{$tSL->unit}}</td>
                            <td class="txt-right" align="right">{{number_format($tSL->m_price,0,',','.')}}</td>
                            <td class="txt-right" align="right">{{number_format($tSL->t_price,0,',','.')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 34)."<br/>");
            ?>
            
            <!--TOTAL BELANJA -->
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>Total Item</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">{{$trStore->t_item}} item</td>
                    </tr>
                    <tr>
                        <td>Sub Total</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">{{number_format($trStore->t_bill,0,',','.')}}</td>
                    </tr>
                    <tr>
                        <td>Sisa Bon Lama</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">
                            <?php
                                if($countBilling >= '1'){
                                    $lastKredit = $remainKredit->kredit;
                                }
                                else{
                                    $lastKredit = '0';
                                }
                            ?>
                            {{number_format($lastKredit,0,',','.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">
                            <?php
                                $total = $lastKredit + $trStore->t_bill;
                            ?>
                            {{number_format($total,0,',','.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Bayar</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">
                            <?php
                                $totalBayar = $trStore->t_bill - $total;
                                if($totalBayar <= '0'){
                                    $displayBayar = '0';
                                }
                                else{
                                    $displayBayar = $totalBayar;
                                }
                            ?>
                            {{number_format($trStore->t_pay,0,',','.')}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php
                                echo (str_repeat("-", 37)."<br/>");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Kembali</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">
                            <?php
                                // $kembaliVal = $total - $paymentRecord->total_payment ;
                                // if($kembaliVal > '0'){
                                //     $kembali = '0';
                                // }
                                // else{
                                //     $kembali = $kembaliVal;
                                // }
                            ?>
                            -
                        </td>
                    </tr>
                    <tr>
                        <td>Saldo Bon</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">
                            <?php
                                // $totalSisaBon = $total - $paymentRecord->total_payment ;
                            ?>
                            {{number_format($cekBon->kredit,0,',','.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Saldo Poin</td>
                        <td class="txt-right" align="right">:</td>
                    </tr>
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 37)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td class="text-center" align="center">Barang yang sudah dibeli tidak dapat dikembalikan, silahkan untuk cek kembali barang yang sudah dibeli sebelum meninggalkan toko.</td>
                    </tr>
                </tbody>
            </table>
            <?php
            $footer = 'Terima kasih atas kunjungan anda';
            $starSpace = ( 32 - strlen($footer) ) / 2;
            $starFooter = str_repeat('*', $starSpace+1);
            echo($starFooter. '&nbsp;'.$footer . '&nbsp;'. $starFooter."<br/><br/><br/><br/>");
            echo '<p>&nbsp;</p>'; 
            ?>
        </section>
    </body>
</html>
<script>
    var lama = 1000;
    t = null;
    function printOut(){
        window.print();
        t = setTimeout("self.close()",lama);
    }
</script>