@extends('layouts.frontpage')
@section('content')
<div class="content mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-body">
                    <a href="#" class="btn btn-app bg-info">
                        <span class="badge bg-info">0</span>
                        <i class="fa-solid fa-table-list"></i> Daftar Kunjungan
                    </a>
                    <a href="{{route('sales')}}/formKunjungan" class="btn btn-app bg-info">                    
                        <i class="fa-solid fa-file"></i> Input Kunjungan
                    </a>
                    <a href="#" class="btn btn-app bg-info">                    
                        <i class="fa-solid fa-chart-line"></i> Sales Dashboard
                    </a>                    
                </div>
                <div class="card card-body border-0 shadow">
                    <div id="displaySales"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h3 class="card-title">Update Data Terbaru</h3>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection