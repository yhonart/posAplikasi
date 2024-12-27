<?php
    $arrStatus = array(
        0=>"Non Aktif",
        1=>"Aktif",
        2=>"Non Member",
    );
    // header("Content-type: application/vnd-ms-excel");
    // header("Content-Disposition: attachment; filename=MasterDataCustomer.xls");
?>
<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Tipe Bayar</th>
            <th>Tipe Penjualan</th>
            <th>Nama Sales</th>
            <th>Status</th>
            <th>Limit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dbCustomer as $dbc)
            <tr>
                <td>{{$dbc->customer_code}}</td>
                <td>{{$dbc->customer_store}}</td>
                <td>{{$dbc->address}}</td>
                <td>{{$dbc->method_name}}</td>
                <td>{{$dbc->group_name}}</td>
                <td>{{$dbc->sales_name}}</td>
                <td>{{$arrStatus[$dbc->customer_status]}}</td>
                <td>{{$dbc->kredit_limit}}</td>
            </tr>
        @endforeach
    </tbody>
</table>