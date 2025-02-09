<?php
    $no = 1;
    $total = 0;
?>
<div class="row mb-2">
    <div class="col-md-12">
        <a href="{{route('piutangPelanggan')}}" class="btn btn-light border-0 font-weight-bold text-info"><i class="fa-solid fa-hand-holding-dollar"></i> Pembayaran Piutang Pelanggan</a>
    </div>
</div>
<table class="table text-nowrap table-hover table-valign-middle table-sm">
    <thead class="font-weight-bold">
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