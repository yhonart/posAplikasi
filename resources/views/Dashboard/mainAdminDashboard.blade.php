@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">    
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-flat">
                        Penjualan
                    </button>
                    <button type="button" class="btn btn-default btn-flat">
                        Pembelian
                    </button>
                    <button type="button" class="btn btn-default btn-flat">
                        Hutang Pelanggan
                    </button>
                    <button type="button" class="btn btn-default btn-flat">
                        Hutang Toko
                    </button>
                    <button type="button" class="btn btn-default btn-flat">
                        Laporan
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="displayAdminDashboard"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        let display = "dashPenjualan";
        $.ajax({
            type : 'get',
            url : "{{route('home')}}/"+display,
            success : function(response){
                $("#displayAdminDashboard").html(response);
            }
        });
    }); 
</script>
@endsection