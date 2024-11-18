<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=ReportTransaksiKas.xls");
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
        background-color: #ffffff;
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
<table class="styled-table" width="100%" border="1">
    <thead class="text-center">
        <tr>
            <th colspan="9"><h5><b>REKAP BIAYA TOKO</b></h5></th>
        </tr>
        <tr>
            <th colspan="9"><b>PT. BERKAH SENTOSA LITANI HARAPAN</b></th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th>No. Trx</th>
            <th>Tgl.</th>
            <th>Deskripsi</th>
            <th>Sub-Kategori</th>
            <th>Keterangan</th>
            <th>User</th>
            <th>Debit</th>
            <th>Lampiran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($displayByDate as $d)
            <tr>
                <td>
                    <?php
                        $dateTk = date("dmy", strtotime($d->kas_date));
                        $idTk = $d->idtr_kas;
                        $noTrx = "KAS" . $dateTk . "-" . sprintf("%07d", $idTk);
                    ?>
                    {{$noTrx}}
                </td>
                <td>{{date("d-M-Y", strtotime($d->kas_date));}}</td>
                <td>{{$d->cat_name}}</td>
                <td>{{$d->subcat_name}}</td>
                <td>{{$d->description}}</td>
                <td>{{$d->kas_persName}}</td>
                <td>{{$d->nominal}}</td>
                <td>
                    @if($d->file_name <> '')
                        <a href="{{asset('public/images/Upload/TrxKas')}}/{{$d->file_name}}" target="_blank" rel="noopener noreferrer" title="{{$d->file_name}}">Lampiran</a>                                    
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>