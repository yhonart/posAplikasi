@extends('layouts.sidebarpage')
@section('content')
<?php
$saldo = 0;
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
                            <dt>Kepada</dt>
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
                                        <td>{{$kR->trx_code}}</td>
                                        <td>{{number_format($kR->total_struk,'0','.',',')}}</td>
                                        <td>{{number_format($kR->saldo_kredit,'0','.',',')}}</td>
                                        <td>{{number_format($kR->total_payment,'0','.',',')}}</td>
                                        <td>
                                            <?php
                                                $saldo = $kR->saldo_kredit - $kR->total_payment;
                                            ?>
                                            {{number_format($saldo,'0','.',',')}}
                                        </td>
                                        <td>{{date('d-M-Y', strtotime($kR->date_trx))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection