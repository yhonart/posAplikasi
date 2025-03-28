@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Admin Master Data Kategori Kas Toko</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">            
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bold">Main Kategori</h3>
                    </div>
                    <div class="card-body text-xs table-responsive" style="height: 500px;">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG  font-weight-bold" href="{{route('kasKategori')}}/addKategori">Tambah Kategori</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="displayTableCategory"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bold">Sub Kategori</h3>
                    </div>
                    <div class="card-body text-xs table-responsive" style="height: 500px;">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG  font-weight-bold" href="{{route('kasKategori')}}/addSubKategori">Tambah Sub Kategori</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="displayTableSubCategory"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $.ajax({
            type : 'get',
            url : "{{route('kasKategori')}}/listTableKategori",
            success : function(response){
                $("#displayTableCategory").html(response);
            }
        });
        $.ajax({
            type : 'get',
            url : "{{route('kasKategori')}}/listTableSubKategori",
            success : function(response){
                $("#displayTableSubCategory").html(response);
            }
        });
    })
</script>
@endsection