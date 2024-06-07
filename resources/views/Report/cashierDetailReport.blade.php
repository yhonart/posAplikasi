<style>
    .styled-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.7em;
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
        font-size :10;
    }
</style>
<?php
    $no = '1';
?>
<div class="judul">
    <p><b>LAPORAN PENDAPATAN KASIR</b></p>
    <span>Tanggal {{$fromDate}} s.d {{$endDate}}</span>
</div>
<table class="styled-table" width="100%">
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
        </tr>
    </thead>
    <tbody>
            <tr>
                <td colspan="9"><b>TUNAI</b></td>
            </tr>
        @foreach($tableReport as $tgR)
            @if($tgR->trx_method=='1')
            <tr>
                <td>{{$no++}}</td>
                <td>{{$tgR->trx_code}}</td>
                <td>{{$tgR->date_trx}}</td>
                <td>{{$tgR->customer_store}}</td>
                <td></td>
                <td>{{number_format($tgR->total_payment,'0',',','.')}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
        @endforeach
            <tr>
                <td colspan="9"><b>TRANSFER</b></td>
            </tr>
        @foreach($tableReport as $tgR1)
            @if($tgR1->trx_method=='9')
            <tr>
                <td>{{$no++}}</td>
                <td>{{$tgR1->trx_code}}</td>
                <td>{{$tgR1->date_trx}}</td>
                <td>{{$tgR1->customer_store}}</td>
                <td></td>
                <td>{{number_format($tgR1->total_payment,'0',',','.')}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
        @endforeach
            <tr>
                <td colspan="9"><b>TEMPO</b></td>
            </tr>
        @foreach($tableReport as $tgR2)
            @if($tgR2->trx_method=='8')
            <tr>
                <td>{{$no++}}</td>
                <td>{{$tgR2->trx_code}}</td>
                <td>{{$tgR2->date_trx}}</td>
                <td>{{$tgR2->customer_store}}</td>
                <td></td>
                <td>{{number_format($tgR2->nominal,'0',',','.')}}</td>
                <td></td>
                <td>{{number_format($tgR2->nom_kredit,'0',',','.')}}</td>
                <td>{{number_format($tgR2->nominal,'0',',','.')}}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>