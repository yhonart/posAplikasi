@extends('layouts.sidebarpage')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penjualan {{$akun}} <small>Date:{{date('d-M-Y', strtotime($date))}}</small></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item text-muted">Home</li>
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item text-info active">Lap. Kas Besar</li>
                    <li class="breadcrumb-item text-info active">Detail Penjualan</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<?php
    $sumBayar = 0;
    $sumBelanja = 0;
?>
<div class="content mt-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card card-body text-xs table-responsive">
                    <table class="table table-sm table-valign-middle table-hover">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Toko</th>
                                <th>Total Item</th>
                                <th>Total Belanja</th>
                                <th>Total Bayar</th>
                                <th>Pembayaran</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dbDetail as $detail)
                            <tr>
                                <td>{{$detail->billing_number}}</td>
                                <td>{{$detail->customer_name}} <br> <small class="text-muted">{{$detail->address}}</small></td>
                                <td>{{$detail->t_item}}</td>
                                <td class="text-right">{{number_format($detail->t_bill,'0',',','.')}}</td>
                                <td class="text-right font-weight-bol">{{number_format($detail->t_pay,'0',',','.')}}</td>
                                <td>{{$detail->payment1}}, {{$detail->payment2}}</td>
                                <?php
                                    $sumBelanja += $detail->t_bill;
                                    $sumBayar += $detail->t_pay;
                                ?>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{number_format($sumBelanja,'0',',','.')}}</td>
                                <td>{{number_format($sumBayar,'0',',','.')}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection