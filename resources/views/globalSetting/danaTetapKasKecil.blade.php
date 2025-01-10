@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Setup Dana Tetap Kas Kecil</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">            
        <div class="row">
            <div class="col-12">
                <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG  font-weight-bold" href="{{route('setKasKasir')}}/newNominal">Tambah</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <div id="displayTableKasKasir"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection