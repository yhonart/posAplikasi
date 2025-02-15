<link rel="stylesheet" href="{{asset('public/dazbuild/dist/css/adminlte.min.css')}}">
<script src="{{asset('public/dazbuild/dist/js/adminlte.min.js')}}"></script>
<style>
    .styled-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 6;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        border: 1px solid #dee2e6;
    }.styled-table-2 tbody tr th,
    .styled-table thead tr {
        background-color: #1e40af;
        color: #ffffff;
        text-align: left;
    }
    .styled-table th,
    .styled-table td {
        padding: 6px 7px;
        border: 1px solid #dee2e6;
    }
    .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }
    .styled-table tbody{
        vertical-align: top;
        border: 1px solid #dee2e6;
    }
    .styled-table .date_check{
        width: 100%;
    }
    .judul{
        text-align: center;
        font-size: 1em;
        font-family: sans-serif;
    }
    .judul p{
        margin: 0.1em;
    }
    .span {
        font-size :8;
    }
    .total {
        font-size : 7;
    }
    .grand-total {
        font-size : 7;
    }
</style>
<?php
    $no = '1';
    $sumTunai = '0';
    $sumTransfer = '0';
    $sumTempo1 = '0';
    $sumTempo2 = '0';
    $sumPoint = '0';
    $sumBelanja = '0';
    $kurangBayar = '0';
    $bon = '0';
    $return = '0';
    $kreditRecord = '0';
    $sumKreditTf = '0';
    $grndTotalKredit = '0';
    $totalPenerimaan = '0';
    $totalBelanjaTunai = '0';
    $totalBelanjaTransfer = '0';
    $grndTotalBelanja = '0';
?>
<div class="row">
    <div class="col-md-12">
        <div class="judul">
            <p><b>LAPORAN PENDAPATAN KASIR</b></p>
            <span>Tanggal {{$fromDate}} s.d {{$endDate}}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <table class="styled-table text-nowrap table-valign-middle" width="100%">
        <thead style="white-space: nowrap;">
            <tr>
                <th>No</th>
                <th>No. Bukti</th>
                <th>Tgl. Bukti</th>
                <th>Nama Pelanggan</th>
                <th>Total Belanja</th>
                <th>Total Bayar</th>
                <th>Return Jual</th>
                <th>Kurang Bayar</th>
                <th>Bayar BON</th>
                <th>Bank Trf.</th>
                <th>Kasir</th>
            </tr>
        </thead>
        <tbody>
    <!-- Pembayaran TUNAI dan TEMPO -->
                <tr>
                    <td colspan="11"><b>TUNAI & TEMPO</b></td>
                </tr>
            @foreach($trxRecord as $record)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$record->billing_number}}</td>
                    <td>{{date("d-M-Y", strtotime($record->tr_date))}}</td>
                    <td>{{$record->customer_name}}</td>
                    <td>{{number_format($record->t_bill,'0',',','.')}}</td>
                    <td>
                        @foreach($tableMthodPayment as $tgR)
                            @if($tgR->core_id_trx == $record->billing_number AND $tgR->method_name == '1')
                                {{number_format($tgR->nominal,'0',',','.')}}
                                <?php                                    
                                    $totalBelanjaTunai += $tgR->nominal;
                                ?>
                            @endif
                        @endforeach
                    </td>
                    <td>

                    </td>
                    <td>
                        @foreach($tableMthodPayment as $tgr1)
                            @if($tgr1->core_id_trx == $record->billing_number AND $tgr1->method_name == '8')
                                {{number_format($tgr1->nominal,'0',',','.')}}
                                <?php                                    
                                    $sumTempo1 += $tgr1->nominal;
                                ?>
                            @endif
                        @endforeach
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{$record->created_by}}</td>
                </tr>
            @endforeach            
                <tr class="font-weight-bold bg-dark total">
                    <td colspan="4">TOTAL TUNAI & TEMPO</td>
                    <td class="text-right">{{number_format($totalBelanjaTunai,'0',',','.')}}</td>
                    <td class="text-right">                    
                        {{number_format($sumTunai,'0',',','.')}}
                    </td>
                    <td></td>
                    <td class="text-right">{{number_format($sumTempo1,"0",',','.')}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
    <!-- Pembayaran Transfer  -->
                <tr>
                    <td colspan="11"><b>TRANSFER</b></td>
                </tr>
            @foreach($tableMthodPayment as $tgR1)
                @if($tgR1->method_name=='4')
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$tgR1->core_id_trx}}</td>
                    <td>{{$tgR1->date_trx}}</td>
                    <td>{{$tgR1->customer_store}}</td>
                    <td class="text-right">{{number_format($tgR1->total_struk,'0',',','.')}}</td>
                    <td class="text-right">{{number_format($tgR1->nominal,'0',',','.')}}</td>
                    <td></td>
                    <td class="text-right">
                        <?php
                            $kreditByTf = $tgR1->total_struk - $tgR1->total_payment;
                        ?>
                        {{number_format($kreditByTf,'0',',','.')}}
                    </td>
                    <td></td>
                    <td>{{$tgR1->bank_code}}</td>
                    <td>{{$tgR1->created_by}}</td>
                </tr>
                <?php
                    $sumTransfer += $tgR1->nominal;
                    $sumKreditTf += $kreditByTf;
                    $totalBelanjaTransfer += $tgR1->total_struk;
                ?>
                @endif
            @endforeach
                <tr class="font-weight-bold bg-dark total">
                    <td colspan="4">TOTAL TRANSFER</td>
                    <td class="text-right">{{number_format($totalBelanjaTransfer,'0',',','.')}}</td>
                    <td class="text-right">                    
                        {{number_format($sumTransfer,'0',',','.')}}
                    </td>
                    <td></td>
                    <td class="text-right">{{number_format($sumKreditTf,'0',',','.')}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
    <!-- Pembayaran BON  -->
                <tr>
                    <td colspan="11"><b>PEMBAYARAN BON</b></td>
                </tr>
            @foreach($creditRecord as $cR)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$cR->trx_code}}</td>
                    <td>{{$cR->date_trx}}</td>
                    <td>{{$cR->customer_store}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{number_format($cR->total_payment,'0',',','.')}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                    $kreditRecord += $cR->total_payment;
                ?>
            @endforeach
                <tr class="font-weight-bold bg-dark total">
                    <td colspan="4">TOTAL PEMBAYARAN BON</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{number_format($kreditRecord,'0',',','.')}}</td>
                    <td></td>
                    <td></td>
                </tr>
        </tbody>
        <tbody>
    <!-- Transaksi return jual  -->
                <tr>
                    <td colspan="11"><b>RETURN</b></td>
                </tr>
            @foreach($tableReport as $tgR2)
                @if($tgR2->trx_method=='0')
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$tgR2->trx_code}}</td>
                    <td>{{$tgR2->date_trx}}</td>
                    <td>{{$tgR2->customer_store}}</td>
                    <td></td>
                    <td class="text-right">{{number_format($tgR2->nominal,'0',',','.')}}</td>
                    <td></td>
                    <td class="text-right">{{number_format($tgR2->nom_kredit,'0',',','.')}}</td>
                    <td class="text-right">{{number_format($tgR2->nominal,'0',',','.')}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                    $sumTempo1 += $tgR2->nominal;
                    $sumTempo2 += $tgR2->nom_kredit;
                ?>
                @endif
            @endforeach
                <tr class="font-weight-bold bg-dark total">
                    <td colspan="6">TOTAL RETURN</td>
                    <td class="text-right">                    
                        
                    </td>
                    <td></td>
                    <td class="text-right"> </td>
                    <td></td>
                    <td></td>
                </tr>
        </tbody>
        <tbody class="grand-total bg-gray-dark">
            <tr>
                <td colspan="11" class="bg-light"></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">GRAND TOTAL KASIR :</td>
                <?php
                    $grndTotalBayar = $sumTunai + $sumTransfer;
                    $grndTotalKredit = $sumTempo1 + $sumKreditTf;
                    $grndTotalBelanja = $totalBelanjaTunai + $totalBelanjaTransfer;
                    $grndTotalPembelian2 = $totalBelanjaTunai + $totalBelanjaTransfer;
                ?>
                <td class="text-right">{{number_format($grndTotalPembelian2,'0',',','.')}}</td>
                <td class="text-right">{{number_format($grndTotalBayar,'0',',','.')}}</td>
                <td></td>
                <td class="text-right">{{number_format($grndTotalKredit,'0',',','.')}}</td>
                <td class="text-right">{{number_format($kreditRecord,'0',',','.')}}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>    
        <tbody class="grand-total">
            <tr>
                <?php
                    $totalPenerimaan = $grndTotalBayar + $kreditRecord;
                ?>
                <td colspan="4" class="text-right"><b>TOTAL PENERIMAAN KASIR</b> <small>GRND TOTAL BAYAR + GRND TOTAL BAYAR BON</small> :</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right" colspan="2"><b>{{number_format($totalPenerimaan,'0',',','.')}}</b></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    </div>
</div>
<?php
    $noPengeluaran = '1';
    $totalPengeluaran = '0';
    $totalKasir = '0';
    $totalLapKasir = '0';
?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="judul">
                    <p><b>PENGELUARAN KASIR</b></p>
                </div>
            </div>
        </div>
        <table class="styled-table text-nowrap table-valign-middle" width="100%">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Kasir</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengeluaranKasir as $pengeluaran)
                    <tr>
                        <td>{{$pengeluaran->purchase_number}}</td>
                        <td>{{$pengeluaran->kasir}}</td>
                        <td>Pembayaran {{$pengeluaran->purchase_number}}-{{$pengeluaran->store_name}}</td>
                        <td class="text-right">{{number_format($pengeluaran->nominal,'0',',','0')}}</td>
                    </tr>
                    <?php
                        $totalPengeluaran +=$pengeluaran->nominal;
                    ?>  
                @endforeach
                <tr>
                    <td class="text-right font-weight-bold">TOTAL PENGELUARAN KASIR</td>
                    <td class="text-right" colspan="3">{{number_format($totalPengeluaran,'0',',','.')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="styled-table text-nowrap table-valign-middle" width="100%">
            <thead>
                <tr>
                    <th class="font-weight-bold" colspan="4">LAPORAN PER KASIR</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$fromDate}} s.d {{$endDate}}</td>
                    <td>{{number_format($totalPenerimaan,'0',',','.')}}</td>
                    <td>{{number_format($totalPengeluaran,'0',',','.')}}</td>
                    <td>
                        <?php
                            $totalLapKasir = $totalPenerimaan - $totalPengeluaran;
                        ?>
                        {{number_format($totalLapKasir,'0',',','.')}}
                    </td>
                </tr>                
            </tbody>
        </table>
    </div>
</div>

<?php
    $noBank = '1';
?>
<div class="row">
    <div class="col-6">
        <table class="styled-table text-nowrap table-valign-middle">
            <thead>
                <tr>
                    <th colspan="4">REKAP TRANSFER BANK</th>
                </tr>
                <tr>
                    <th>No.</th>
                    <th>Kode Bank</th>
                    <th>Nama Bank</th>
                    <th>Jumlah Transfer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bankTransaction as $bankT)
                    <tr>
                        <td>{{$noBank++}}</td>
                        <td>{{$bankT->bank_code}}</td>
                        <td>{{$bankT->bank_name}}</td>
                        <td class="text-right">{{number_format($bankT->totalTransfer)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>