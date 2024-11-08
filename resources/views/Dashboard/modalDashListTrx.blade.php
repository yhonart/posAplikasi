<?php
    $no = '1';
    $arayStatus = array(
        0=>"Trs. Batal",
        1=>"Dlm. Proses",
        2=>"Hold",
        3=>"Kredit",
        4=>"Trs. Sukses",
    );
    $total = '0';
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
                            <td class="text-right">
                                {{number_format($hisTrx->unit_price,'0',',','.')}}
                            </td>
                            <td class="text-right">
                                {{number_format($hisTrx->disc,'0',',','.')}}
                            </td>
                            <td class="text-right">
                                {{number_format($hisTrx->t_price,'0',',','.')}}
                                <?php
                                    $total += $hisTrx->t_price;
                                ?>
                            </td>
                            <td class="text-right">
                                <span class="bg-light border border-1 border-info pl-2 pr-2 pt-1 pb-1 rounded-pill font-weight-bold text-xs">
                                    {{$arayStatus[$hisTrx->status]}}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="6" class="bg-light font-weight-bold">Total </td>
                            <td class="bg-light font-weight-bold">{{number_format($total,'0',',','.')}}</td>
                            <td></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>