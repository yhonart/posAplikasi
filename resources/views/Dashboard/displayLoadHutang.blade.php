<?php
    $no = 1;
    $total = 0;
?>
<table>
    <thead>
        <tr>
            <td>No.</td>
            <td>Nama Pelanggan</td>
            <td>Hutang</td>
        </tr>
    </thead>
    <tbody>
        @foreach($hutangPelanggan as $hutang)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$hutang->customer_store}}</td>
                <td>{{number_format($hutang->nominalKredit,'0',',','.')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>