@extends('layouts.sidebarpage')
@section('content')
<?php
$saldo = 0;
$saldo1 = 0;
$sumTHutang = 0;
$sumSisaHutang = 0;
$sumPembayaran = 0;
$sumSaldo = 0;
?>
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{$voucher}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6 d-lg-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item text-muted">Home</li>
                <li class="breadcrumb-item text-muted">Keuangan</li>
                <li class="breadcrumb-item text-info">Piutang Pelanggan</li>
                <li class="breadcrumb-item text-info active">{{$voucher}}</li>
            </ol>
        </div>
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class=" content">
    <div class=" container">
        <div class="card">            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <dl>
                            <dt>Pelanggan :</dt>
                            <dd>
                                {{$faktur->customer_store}} <br>
                                {{$faktur->address}}, {{$faktur->city}} <br>
                                {{$faktur->phone_number}}
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>No.Transaksi</th>
                                    <th>T.Hutang</th>
                                    <th>Sisa Hutang</th>
                                    <th>Pembayaran</th>
                                    <th>Saldo</th>
                                    <th>Tgl.Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kreditRecord as $kR)
                                    <tr>
                                        <td class=" font-weight-bold">{{$kR->trx_code}}</td>
                                        <td class=" text-right text-danger"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($kR->total_struk,'0',',','.')}}</td>
                                        <td class=" text-right text-maroon"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($kR->saldo_kredit,'0',',','.')}}</td>
                                        <td class=" text-right text-success"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($kR->total_payment,'0',',','.')}}</td>
                                        <td class=" text-right text-info">
                                            <?php
                                                $saldo1 = $kR->saldo_kredit - $kR->total_payment;
                                                $sumTHutang += $kR->total_struk;
                                                $sumSisaHutang += $kR->saldo_kredit;
                                                $sumPembayaran += $kR->total_payment;
                                                $sumSaldo += $saldo;

                                                if ($saldo1 <= 0) {
                                                    $saldo = 0;
                                                }
                                                else {
                                                    $saldo = $saldo1;
                                                }
                                            ?>
                                            <i class="fa-solid fa-rupiah-sign"></i> {{number_format($saldo,'0','.',',')}}
                                        </td>
                                        <td>{{date('d-M-Y', strtotime($kR->date_trx))}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class=" bg-dark" colspan="6"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Subtotal</th>
                                    <th class=" text-right text-danger"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($sumTHutang,'0',',','.')}}</th>
                                    <th class=" text-right text-maroon"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($sumSisaHutang,'0',',','.')}}</th>
                                    <th class=" text-right text-success"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($sumPembayaran,'0',',','.')}}</th>
                                    <th class=" text-right text-info"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($sumSaldo,'0',',','.')}}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection