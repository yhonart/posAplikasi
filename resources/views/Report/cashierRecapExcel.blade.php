<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=ReportHarian.xls");
    $no = '1';
?>
<link rel="stylesheet" href="{{asset('public/dazbuild/dist/css/adminlte.min.css')}}">
<script src="{{asset('public/dazbuild/dist/js/adminlte.min.js')}}"></script>
<style>
    .styled-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 12;
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
    $sumHrgSatuan = '0';
    $sumJumlah = '0';
?>
<table class="styled-table" width="100%" border="1">
    <thead class="text-center">
        <tr>
            <th>Tanggal</th>
            <th>No.Trx</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>No. Pelanggan</th>
            <th>Nama Pelanggan</th>
            <th>Alamat</th>
            <th>Tlp.</th>
            <th>Tipe Pelanggan</th>
            <th>Satuan</th>
            <th>Qty</th>
            <th>Hrg. Satuan</th>
            <th>disc</th>
            <th>Jumlah</th>
            <th>Pembayaran 1</th>
            <th>Pembayaran 2</th>
            <th>Tempo</th>
            <th>Kasir</th>
            <th>Pengirim</th>
            <th>Transaksi</th>
            <th>Status 1</th>
            <th>Status 2</th>
            <th>Supplier</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prdTrx as $ptrx)
            <tr>
                <td>{{$ptrx->tr_date}}</td>
                <td>{{$ptrx->billing_number}}</td>
                <td>{{$ptrx->product_code}}</td>
                <td>{{$ptrx->product_name}}</td>
                <td>{{$ptrx->customer_code}}</td>
                <td>{{$ptrx->customer_name}}</td>
                <td>{{$ptrx->address}}</td>
                <td></td>
                <td></td>
                <td>{{$ptrx->unit}}</td>
                <td>{{$ptrx->qty}}</td>
                <td>{{$ptrx->unit_price}}</td>
                <td>{{$ptrx->disc}}</td>
                <td>{{$ptrx->t_price}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$ptrx->created_by}}</td>
                <td>{{$ptrx->tr_delivery}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
                $sumHrgSatuan += $ptrx->unit_price;
                $sumJumlah += $ptrx->t_price;
            ?>
        @endforeach
            <tr>
                <td colspan="11"> <b>TOTAL</b> </td>
                <td> <b>{{$sumHrgSatuan}}</b> </td>
                <td></td>
                <td> <b>{{$sumJumlah}}</b> </td>
                <td colspan="9"></td>
            </tr>
    </tbody>
</table>
<H4>RECAP SUMMARY TOTAL BELANJA</H4>
<table>
    <thead>
        <tr>
            <th>Number</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tempTPrice as $tmp)
            <tr>
                <td>{{$tmp->billing_number}}</td>
                <td>{{$tmp->sumTPrice}}</td>
            </tr>
        @endforeach
    </tbody>
</table>