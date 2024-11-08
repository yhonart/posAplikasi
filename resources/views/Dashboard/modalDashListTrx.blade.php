<?php
    $no = '1';
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body teble-responsive">
            <p>Log Data Transaksi</p>
            <table class="table table-sm table-valign-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Hrg. Satuan</th>
                        <th>Disc</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dbSelectTrx as $hisTrx)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$hisTrx->product_name}}</td>
                            <td>{{$hisTrx->qty}}</td>
                            <td>{{$hisTrx->unit}}</td>
                            <td>{{$hisTrx->unit_price}}</td>
                            <td>{{$hisTrx->disc}}</td>
                            <td>{{$hisTrx->t_price}}</td>
                            <td>{{$hisTrx->status}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>