<?php
    $no = '1';
?>
<table class="table table-sm tabl-valign-middle table-hover">
    <thead class="bg-gray">
        <tr>
            <th>No.</th>
            <th>Nama Pelanggan</th>
            <th>Limit Kredit</th>
            <th>Total Hutang</th>
            <th>Total Dibayar</th>
            <th>Selisih Hutang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sumSaldoCustomer as $ssc)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$ssc->customer_store}}</td>
                <td>{{$ssc->kredit_limit}}</td>
                <td>{{$ssc->nominal}}</td>
                <td>{{$ssc->nomPayed}}</td>
                <td>{{$ssc->saldoKredit}}</td>
            </tr>
        @endforeach
    </tbody>
</table>