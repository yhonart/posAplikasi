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
    <div class="container-fluid"> 
        <div class="row mt-2 mb-2">
            <div class="col-12">
                <button type="button" class="btn btn-outline-primary font-weight-bold BTN-CLICK" data-display="tableDataMutasi">List Dokumen Mutasi</button>
                <button type="button" class="btn btn-primary font-weight-bold BTN-CLICK" data-display="formEntryMutasi">Entri Mutasi</button>
            </div>
        </div>
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