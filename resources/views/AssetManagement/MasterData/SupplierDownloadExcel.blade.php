<?php
    $no = 1;
    $arrStatus = array(
        0=>"Non Aktif",
        1=>"Aktif",
        2=>"Non Member",
    );
?>
<table width="100%" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Supplier</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Type Pembayaran</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($masterSupplier as $ms)
            <tr>
                <td>{{$no++}}</td>
                <td>SUP{{sprintf("%07d", $ms->idm_supplier)}}</td>
                <td>{{$ms->store_name}}</td>
                <td>{{$ms->address}}</td>
                <td>{{$ms->city}}</td>
                <td>{{$ms->payment_type}}</td>
                <td>{{$ms->payment_type}}</td>
                <td>
                    @if($ms->supplier_status <> '')
                    {{$arrStatus[$ms->supplier_status]}}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>