<html>
    <head>
        <title>Cetak Nota</title>
        <link rel="stylesheet" href="{{asset('public/css/print.css')}}">
    </head>
    <body class="struk" onload="printOut()">
        <section class="sheet">
            <table cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>{{$companyName->company_name}}</td>
                    </tr>
                    <tr>
                        <td>{{$companyName->address}}</td>
                    </tr>
                </tbody>
            </table>
            <?php
                echo (str_repeat("=", 40)."<br/>");
            ?>
            <table>
                <tbody>
                    <tr>
                        <td>No</td>
                        <td>: {{$trStore->billing_number}}</td>
                        <td>{{$trStore->tr_date}}</td>
                    </tr>
                    <tr>
                        <td>Cus</td>
                        <td>: {{$trStore->customer_name}}</td>
                        <td>{{date("H:i:s",strtotime($trStore->created_date))}}</td>
                    </tr>
                    <tr>
                        <td>Ksr</td>
                        <td>: {{$trStore->created_by}}</td>
                        <td>{{date("H:i:s")}}</td>
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
                            <td class="txt-left" align="left">{{$tSL->qty}}x</td>
                            <td class="txt-right" align="right">{{number_format($tSL->unit_price,0,',','.')}}</td>
                            <td class="txt-right" align="right">{{number_format($tSL->t_price,0,',','.')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 37)."<br/>");
            ?>
            
            <!--TOTAL BELANJA -->
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>Total Item</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">{{$trStore->t_item}}</td>
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
                            @if(!empty($cekBon))
                                @php
                                    $lastKredit = $cekBon->nom_last_kredit;
                                @endphp
                                {{number_format($cekBon->nom_last_kredit,0,',','.')}}
                            @else
                                @php
                                    $lastKredit = '0';
                                @endphp
                                0
                            @endif
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
                        <td colspan="3">
                            <?php
                                echo (str_repeat("-", 37)."<br/>");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Bayar</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">
                            {{number_format($paymentRecord->total_payment,0,',','.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Kembali/Kredit</td>
                        <td class="txt-right" align="right">:</td>
                        <td class="txt-right" align="right">
                            <?php
                                if(!empty($cekBon)){
                                    $nomKredit = $cekBon->nom_kredit;
                                }
                                else{
                                    $nomKredit = '0';
                                }
                                
                                
                                $kembaliVal = $nomKredit - $paymentRecord->total_payment ;
                                if($kembaliVal > '0'){
                                    $kembali = '0';
                                }
                                else{
                                    $kembali = $kembaliVal;
                                }
                            ?>
                            {{number_format(abs($kembali),0,',','.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Saldo Poin</td>
                        <td class="txt-right" align="right">:</td>
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