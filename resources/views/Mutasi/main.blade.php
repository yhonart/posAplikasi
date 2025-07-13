@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Mutasi Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item text-muted">Home</li>
                <li class="breadcrumb-item text-muted">Inventory</li>
                <li class="breadcrumb-item text-info active">Mutasi Barang</li>
            </ol>
        </div>
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid mb-2">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg" style="width:100%;">                        
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">                                
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link BTN-CLICK font-weight-bold" href="#" data-display="formEntryMutasi" data-toggle="tab" id="createMutasi">
                                    <i class="fa-solid fa-plus"></i> Buat Transaksi
                                </a>
                            </li>                                                                                               
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link BTN-CLICK font-weight-bold" href="#" data-display="tableDataMutasi" data-toggle="tab" id="listMutasi">
                                    <i class="fa-solid fa-table-list"></i> List Dok.Mutasi
                                </a>
                            </li>                                                                                                 
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">                
                <div class="text-center LOAD-SPINNER text-sm" style="display:none;">    
                    <span class="spinner-border spinner-border-sm text-danger" role="status"></span> Loading ...
                </div>                
                <div id="displayMutasi"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(function(){
        var route = "tableDataMutasi",
            display = $("#displayMutasi");
            
        displayMutasi(display, route);
    })
    
    
    $('.BTN-CLICK').on('click', function (e) {
        e.preventDefault();
        let ell = $(this);
        var route = ell.attr("data-display"),
            display = $("#displayMutasi");
        displayMutasi(display, route);
    });
    
    function displayMutasi(display, route) {
        $(".LOAD-SPINNER").fadeIn("slow");
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/"+route,
            success : function(response){
                $(".LOAD-SPINNER").fadeOut("slow");
                $('#displayMutasi').html(response);
            }
        });
    } 
</script>
@endsection