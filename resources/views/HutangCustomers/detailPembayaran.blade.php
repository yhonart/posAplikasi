@extends('layouts.sidebarpage')
@section('content')
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
            <div class="card-header border-0">
                <h3 class="card-title">Detail Pembayaran</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection