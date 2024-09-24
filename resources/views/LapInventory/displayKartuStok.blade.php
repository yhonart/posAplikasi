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
<div class="judul">
    <p><b>TOKO </b></p>
    <p><b>DAFTAR KARTU STOCK BARANG</b></p>
</div>
<table class="table table-sm table-borderless text-xs text-nowrap" width="100%">
    <tbody>
        <tr>
            <td>Persediaan</td>
            <td>: {{$mProduct->product_code}} {{$mProduct->product_name}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td>: {{$locData->company_code}} {{$locData->site_name}}</td>
            <td>Tanggal Cetak</td>
            <td>{{date("d-M-Y")}}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{date('d/M/Y', strtotime($fromDate))}} s.d {{date('d/M/Y', strtotime($endDate))}}</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
<table class="table table-sm text-xs table-bordered border-2">
    <thead style="white-space: nowrap;" class="bg-gray">
        <tr>
            <th>Tanggal </th>
            <th>Nomor Bukti</th>
            <th>Product</th>
            <th>Keterangan</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($codeDisplay == '1') {
                echo "<tr>";
                    echo "<td>".$dataSaldoAwal->date_input."</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td>Saldo Awal</td>";
                    echo "<td class='text-right'>0</td>";
                    echo "<td class='text-right'>0</td>";
                    echo "<td class='text-right'>";
    
                    if ($dataSaldoAwal->inv_in == '0') {
                        $saldoawal = $dataSaldoAwal->saldo + $dataSaldoAwal->inv_out;
                    }
                    else {
                        $saldoawal = $dataSaldoAwal->saldo - $dataSaldoAwal->inv_in;
                    }
    
                    if ($mProduct->medium_unit_val == '0') {
                        $awal = $saldoawal;
                    }
                    elseif ($mProduct->small_unit_val == '0') {
                        $awal = $saldoawal * $mProduct->medium_unit_val;
                    }
                    else {
                        $awal = $saldoawal * $mProduct->small_unit_val;
                    }
                    echo $saldoawal;
                    echo "</td>";
                echo "</tr>";
            }
        ?>
        @foreach($dataReportInv as $dri)
            <tr>
                <td>{{$dri->date_input}}</td>
                <td>{{$dri->number_code}}</td>
                <td>{{$dri->product_name}}</td>
                <td>{{$dri->description}}</td>
                <td class="text-right">{{$dri->inv_in}}</td>
                <td class="text-right">{{$dri->inv_out}}</td>
                <td class="text-right">
                    {{$dri->saldo}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>