@extends('layouts.sidebarpage')
@section('content')

<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Pengaturan Nama Usaha</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">                
                <a class="btn btn-primary btn-sm font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href = "{{route('setLokasi')}}/newLokasi">Tambah Lokasi</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="listTableLokasiToko"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $("#listTableLokasiToko").load("{{route('setLokasi')}}/tableDataLokasi");
    });
</script>
@endsection