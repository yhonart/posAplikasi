@extends('layouts.frontpage')
@section('content')
<div class="row">
    <div class="col-12 text-center">
        <h3 class="font-weight-bold">FAKTUR</h3>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <p>Kepada Yth.</p>
        <p>{{$trStore->customer_name}}</p>
        <address>
            {{$trStore->address}}
        </address>
        <p>Kota : </p>
    </div>
    <div class="col-4">
        <dl class="row">
            <dt class="col-4">No.</dt>
            <dd class="col-8">{{$trStore->billing_number}}</dd>
        </dl>
        <dl class="row">
            <dt class="col-4">Tanggal</dt>
            <dd class="col-8">{{$trStore->tr_date}}</dd>
        </dl>
    </div>
</div>
<?php
    $no = '1';
?>
<div class="row">
    <div class="col-12">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trStoreList as $list)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$list->qty}}</td>
                        <td>{{$list->unit}}</td>
                        <td>{{$list->product_name}}</td>
                        <td class="text-right">{{number_format($list->unit_price,'0',',','.')}}</td>
                        <td class="text-right">{{number_format($list->t_price,'0',',','.')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <p>Keterangan</p>
    </div>
    <div class="col-6">
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td>Sub. Total</td>
                    <td class="text-right">:</td>
                    <td class="text-right">{{number_format($totalPayment->totalBilling,'0',',','.')}}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td class="text-right">:</td>
                    <td class="text-right">{{number_format($totalPayment->sumDisc,'0',',','.')}}</td>
                </tr>
                <tr>
                    <td>Bon Lalu</td>
                    <td class="text-right">:</td>
                    <td class="text-right">{{number_format($cekBon->nominal,'0',',','.')}}</td>
                </tr>
                <tr>
                    <td>PPN</td>
                    <td class="text-right">:</td>
                    <td class="text-right">{{$trStore->ppn}}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-right">:</td>
                    <td class="text-right">
                        <?php
                            $total = $totalPayment->totalBilling+$cekBon->nominal;
                        ?>
                        {{number_format($total,'0',',','.')}}
                    </td>
                </tr>
            </tbody>
            <tfother>
                <tr>
                    <td>Tunai</td>
                    <td class="text-right">:</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td>Kembali</td>
                    <td class="text-right">:</td>
                    <td class="text-right"></td>
                </tr>
            </tfother>
        </table>
    </div>
</div>
<script>
    window.addEventListener("load", window.print());
</script>
@endsection