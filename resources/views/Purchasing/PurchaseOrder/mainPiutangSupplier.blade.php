@extends('layouts.sidebarpage')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembayaran Hutang <small>(Payble/AP)</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-muted">Home</li>
                        <li class="breadcrumb-item text-muted">Keuangan</li>
                        <li class="breadcrumb-item text-info active">Payble/AP</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content mt-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <button type="button" class="btn bg-light-blue CLICK-AP" data-display="inputPembayaran">Pembayaran</button>
                    <button type="button" class="btn bg-light-blue CLICK-AP" data-display="historyPembayaran">History</button>
                    <button type="button" class="btn bg-light-blue CLICK-AP" data-display="dashboardPembayaran">Dashboard AP</button>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12">
                    <div id="displayAP"></div>
                </div>
            </div>

            
        </div>
    </div>

    <script>
        
    </script>
@endsection