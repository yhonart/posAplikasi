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
                <div class="card card-body border-0 shadow-none table-responsive">
                    <a href="#" class="btn btn-info btn-flat BTN-CLICK ml-2 mt-1" data-display="formKunjungan">                    
                        <i class="fa-solid fa-file"></i> Input Kunjungan
                    </a>
                    <a href="#" class="btn btn-default btn-flat BTN-CLICK ml-2 mt-1" data-display="daftarKunjungan">
                        <span class="badge bg-danger">0</span>
                        <i class="fa-solid fa-table-list"></i> Daftar Kunjungan
                    </a>
                    <a href="#" class="btn btn-default btn-flat BTN-CLICK ml-2 mt-1" data-display="salesDasboard">                    
                        <i class="fa-solid fa-chart-line"></i> Sales Dashboard
                    </a>
                </div>
                <div class="card card-body border-0 shadow mt-2">
                    <div id="divSpinner" style="display: none;">
                        <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.BTN-CLICK').on('click', function (e) {
        e.preventDefault();
        let ell = $(this);
        var route = ell.attr("data-display"),
            display = $("#displaySales");
        displaySales(display, route);
    });

    function displaySales(display, route) {
        $("#divSpinner").fadeIn("slow");
        $.ajax({
            type : 'get',
            url : "{{route('sales')}}/"+route,
            success : function(response){
                $("#divSpinner").fadeOut("slow");
                $('#displaySales').html(response);
            }
        });
    } 
</script>
@endsection