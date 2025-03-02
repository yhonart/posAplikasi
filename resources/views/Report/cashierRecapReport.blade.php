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
        background-color: #17a2b8;
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
        font-size : 8;
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
    $grndTotal = '0';
?>
<div class="judul">
    <p><b>LAPORAN PENDAPATAN KASIR</b></p>
    <span>Tanggal {{$fromDate}} s.d {{$endDate}}</span>
</div>
<table class="styled-table text-nowrap" width="100%">
    <thead style="white-space: nowrap;">
        <tr>
            <th>Keterangan</th>
            <th>Total Penjualan</th>
            <th>Total Tunai</th>
            <th>Total Transfer</th>
            <th>Total EDC Kartu</th>
            <th>Total Kredit</th>
            <th>Pembayaran BON</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                @if($customer <> '0' OR $customer == '' OR $customer == null)
                    {{$customerIden->customer_store}} <small class="text-muted">{{$customerIden->address}}</small>
                @else
                    Penjualan Dari Tgl {{$fromDate}} s.d {{$endDate}}
                @endif
            </td>
            <td class="text-right">{{number_format($tableReport->total_struk,'0',',','.')}}</td>
            <td class="text-right">{{number_format($tableReportTunai->total_payment,'0',',','.')}}</td>
            <td class="text-right">{{number_format($bankTransaction->totalTransfer,'0',',','.')}}</td>
            <td class="text-right"></td>
            <td class="text-right">
                <?php
                    $totalKredit = $tableReport->total_struk - $tableReport->total_payment;
                ?>
                {{number_format($totalKredit,'0',',','.')}}
            </td>
            <td class="text-right">
                {{number_format($creditRecord->totalBon,'0',',','.')}}
            </td>
        </tr>
        <tr>
            <td>GRAND TOTAL (T.Tunai + T.Transfer + T. EDC + Pembayaran BON)</td>
            <td colspan="6" class="text-right grand-total">
                <?php
                    $grndTotal = $tableReportTunai->total_payment + $bankTransaction->totalTransfer + $totalKredit + $creditRecord->totalBon;
                ?>
                <b>{{number_format($grndTotal,'0',',','.')}}</b>
                
            </td>
        </tr>
    </tbody>
</table>