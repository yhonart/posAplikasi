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
                        <td style="text-align: center; vertical-align: middle;">
                            @if(!empty($companyName))
                                {{$companyName->company_name}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;">LAPORAN HARIAN CLOSING KASIR</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php
                echo (str_repeat("=", 34)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td align="right">: {{Auth::user()->name}};</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td align="right">: </td>
                    </tr>
                    <tr>
                        <td>Modal Kas</td>
                        @if(!empty($mSetKas))
                            <td align="right">: {{number_format($mSetKas->nominal,'0',',','.')}}</td>
                            @else
                            <td align="right">: 0</td>
                        @endif
                    </tr>
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 34)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>Transaksi Tunai</td>
                        <td  align="right">: {{number_format($trxTunai->total_payment,'0',',','.')}}</td>
                    </tr>
                    <tr>
                        <td>Pembayarn Hutang</td>
                        <td align="right">: 
                            <?php
                                if($trxPbHutang->total_payment == ''){
                                    $nomPbHutang = '0';
                                }
                                else{
                                    $nomPbHutang = $trxPbHutang->total_payment;
                                }
                                echo number_format($nomPbHutang,'0',',','.');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Diskon</td>
                        <td align="right">: {{number_format($trxDisc->disc,'0',',','.')}}</td>
                    </tr>
                    <tr>
                        <td>Nota Kredit</td>
                        <td align="right">:
                            - {{number_format($trxKredit->total_struk,'0',',','.')}}
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
                        <td colspan="2">Transaksi Non Tunai</td>
                    </tr>
                    <tr>
                        <td>Kredit</td>
                        <td align="right">: ??? </td>
                    </tr>
                    <tr>
                        <td colspan="2">Transfer</td>
                    </tr>
                    @foreach($bankTransaction as $bankT)
                        <tr>
                            <td>{{$bankT->bank_name}}</td>
                            <td align="right">: {{number_format($bankT->totalTransfer,'0',',','.')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 34)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td colspan="2">Penerimaan Lain-Lain</td>
                    </tr>
                    <tr>
                        <td>Piutang</td>
                        <td align="right">: {{number_format($creditRecord->total_payment,'0',',','.')}}</td>
                    </tr>
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 34)."<br/>");
            ?>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td colspan="2">Pengeluaran</td>
                    </tr>
                    <tr>
                        <td>Hutang</td>
                        <td align="right">: ???</td>
                    </tr>
                    <tr>
                        <td>Kas Kecil</td>
                        <td align="right">: 0</td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>Total Transaksi</td>
                        <td align="right">: </td>
                    </tr>
                    <tr>
                        <td>Stor Tunai Kasir</td>
                        <td align="right">: </td>
                    </tr>
                </tbody>
            </table>
            <?php
                echo (str_repeat("-", 34)."<br/>");
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