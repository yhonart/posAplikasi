@extends('layouts.frontpage')
@section('content')
<script type="text/javascript">
    const route_main = "{{route('sales')}}";
</script>
<div class="content mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body border-0 shadow-none table-responsive">
                    <div class="row">
                        <div class="col-md-12">
                            <nav class="navbar navbar-expand-lg" style="width:100%;">
                                <span class="d-flex navbar-brand">Sales Activity</span>
                
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">                                        
                                        <li class="nav-item">
                                            <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="formKunjungan" data-toggle="tab" id="tabMenuDash">
                                                Input Kunjungan
                                            </a>
                                        </li>                                                                     
                                        <li class="nav-item">
                                            <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="daftarKunjungan" data-toggle="tab" id="tabMenuDash">
                                                Daftar Kunjungan
                                            </a>
                                        </li>                                                                     
                                        <li class="nav-item">
                                            <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="salesDasboard" data-toggle="tab" id="tabMenuDash">
                                                Sales Dashboard
                                            </a>
                                        </li>                                                                     
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card card-body border-0 shadow mt-2 table-responsive">
                    <div id="divSpinner" style="display: none;">
                        <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div id="displaySales"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $("#displaySales").load(route_main+'/daftarKunjungan');
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('.ITEM-MAIN-MENU').on('click', function (e) {
            e.preventDefault();
            let ell = $(this);
            var route = ell.attr("data-path");
            displaySales(route);
        });
    
        function displaySales(route) {
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