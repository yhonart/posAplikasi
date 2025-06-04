@extends('layouts.frontpage')
@section('content')
<div class="content mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                          <nav class="navbar navbar-expand-lg" style="width:100%;">
                    <span class="d-flex navbar-brand"><span><b>Helpdesk</b> IT</span></span>
    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">
                            <li class="nav-item">
                                <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="main_dashboard" data-toggle="tab" id="tab-menu-dash">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="main_report" data-toggle="tab" id="tab-menu-report">
                                    Issues
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="main_borrow" data-toggle="tab" id="tab-menu-borrow">
                                    Equip. Loan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="main_request" data-toggle="tab" id="tab-menu-request">
                                    Request
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>        
</div>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var route = "daftarKunjungan",
            display = $("#displaySales");
        displaySales(display, route);
        
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
    });
</script>
@endsection