@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Stock Opname</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item text-muted">Home</li>
                <li class="breadcrumb-item text-muted">Inventory</li>
                <li class="breadcrumb-item text-info active">Opname</li>
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
                                <a class="nav-link DIS-ONCLICK font-weight-bold" href="#" data-display="listDataOpname" data-toggle="tab" id="pr">
                                    <i class="fa-solid fa-table-list"></i> List Opname
                                </a>
                            </li>                                                                                                 
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link DIS-ONCLICK font-weight-bold" href="#" data-display="listInputBarang" data-toggle="tab" id="productIn">
                                    <i class="fa-solid fa-plus"></i> Buat Transaksi
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
                <div id="displayOpname"></div>
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
        let display = "listDataOpname";
        displayOnClick(display);
    });
    
    $('.DIS-ONCLICK').on('click', function (e) {
        e.preventDefault();
        let el = $(this);
        let display = el.attr("data-display");
        displayOnClick(display);
    });
    
    function displayOnClick(display){
        $("#displayNotif").fadeIn("slow");
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/"+display,
            success : function(response){
                $('#displayOpname').html(response);
                $("#displayNotif").fadeOut("slow");
            }
        });
    }
</script>
@endsection