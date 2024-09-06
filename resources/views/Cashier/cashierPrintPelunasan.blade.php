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
        text-align: left;
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
<div class="judul">
    <h3><b>{{$namaToko->company_name}}</b></h3>
    <p>Nomor : {{$listVoucher->payment_number}}</p>
    <p>Tanggal : {{$listVoucher->created_at}}</p>
    <p>Terima Dari : {{$listVoucher->customer_store}}</p>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>NO. PERKIRAAN</th>
            <th>KETERANGAN</th>
            <th>DEBIT</th>
            <th>KREDIT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="height:5%"><p></p><p></p>{{$listVoucher->account_code}}</td>
            <td><p></p><p></p>{{$listVoucher->account_name}}</td>
            <td><p></p><p></p>{{number_format($listVoucher->debit,'0',',','.')}}</td>
            <td><p></p><p></p>{{number_format($listVoucher->kredit,'0',',','.')}}</td>
        </tr>
    </tbody>
</table>
<h5>Terbilang : </h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Dibuat Oleh</th>
            <th>Diperiksa/Diketahui</th>
            <th>Dibukukan Oleh</th>
            <th>Diterima Dari</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="height:5%">
                <p></p>
                <p></p>
                <p></p>
                {{$listVoucher->created_by}}
            </td>
            <td><p></p>
                <p></p>
                <p></p>
            </td>
            <td><p></p>
                <p></p>
                <p></p>
                </td>
            <td><p></p>
                <p></p>
                <p></p></td>
        </tr>
    </tbody>
</table>
