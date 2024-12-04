<html>
    <head>
        <title>Cetak Nota</title>
        <link rel="stylesheet" href="{{asset('public/css/print.css')}}">
    </head>
    <body class="struk" onload="printOut()">
        <?php
            $totalBelanja = '0';
        ?>
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
                <tbody>
                    @foreach($trStoreList as $tSL)
                        <tr>
                            <td>
                                {{$tSL->product_name}}
                            </td>
                        </tr>
                        <tr>
                            <td class="txt-left" align="left">{{$tSL->qty}} {{$tSL->unit}} {{number_format($tSL->m_price,0,',','.')}}</td>
                            <td class="txt-right" align="right">{{number_format($tSL->t_price,0,',','.')}}</td>
                        </tr>
                        <?php
                            $totalBelanja += $tSL->t_price;
                        ?>
                    @endforeach
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 34)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>Total Item</td>
                        <td>:</td>
                        <td class="txt-right" align="right">{{$totalPayment->countList}}</td>
                    </tr>
                    <tr>
                        <td>Total Belanja</td>
                        <td>:</td>
                        <td class="txt-right" align="right">{{number_format($totalBelanja,0,',','.')}}</td>
                    </tr>
                    <tr>
                        <td>Hutang Sebelumnya</td>
                        <td>:</td>
                        <td class="txt-right" align="right">
                            <?php
                                if($countBilling >= '1'){
                                    $lastKredit = $remainKredit->kredit;
                                }
                                else{
                                    $lastKredit = $cekBon->kredit;
                                }
                            ?>
                            {{number_format($lastKredit,0,',','.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Tunai</td>
                        <td>:</td>
                        <td class="txt-right" align="right">{{number_format($trStore->t_pay,0,',','.')}}</td>
                    </tr>
                    <tr>
                        <td>Kembali</td>
                        <td>:</td>
                        <td class="txt-right" align="right">
                            <?php
                                // $kembali = $trStore->t_bill - $trStore->t_pay;
                                $kembali = $totalBelanja - $trStore->t_pay;
                            ?>
                            {{number_format(abs($kembali),'0',',','.')}}
                        
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 34)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>Saldo Hutang</td>
                        <td>:</td>
                        <td class="txt-right" align="right">
                            {{number_format($cekBon->kredit,0,',','.')}}
                        </td>
                    </tr>
                    <tr>
                        <td>Saldo Poin</td>
                        <td>:</td>
                        <td class="txt-right" align="right">0</td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    @foreach($paymentRecord as $pr)
                        <tr>
                            <td>Pembayaran</td>
                            <td class="txt-right" align="right">
                                {{$pr->methodName}} <br>
                            </td>
                            <td class="txt-right" align="right">{{number_format($pr->nominal,0,',','.')}}</td>
                        </tr>
                        @if($pr->codeMethod == '4')
                        <tr>
                            <td>Bank Trf.</td>
                            <td>{{$pr->namaBank}}</td>
                            <td class="txt-right" align="right">{{substr($pr->norek,0,4)}}.xxxxx</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 34)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td class="text-center" align="center">Barang yang sudah dibeli tidak dapat dikembalikan, silahkan untuk cek kembali barang yang sudah dibeli sebelum meninggalkan toko.</td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td class="text-center" align="center">*Terima kasih atas kunjungan anda*</td>
                    </tr>
                </tbody>
            </table>
            
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