@extends('layouts.sidebarpage')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penjualan {{$akun}} <small>Date:{{date_format('d-M-Y')}}</small></h1>
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
<div class="content mt-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card card-body table-responsive">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection