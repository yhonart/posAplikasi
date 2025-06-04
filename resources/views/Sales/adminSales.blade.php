@extends('layouts.frontpage')
@section('content')
<div class="content mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand navbar-light">
                    <button type="button" class="navbar-toggler" data-toggler="collapse" data-target="#navbarSupportAdmin" aria-controls="navbarSupportAdmin" aria-expanded="false" aria-label="Toggle Navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse order-3" id="navbarSupportAdmin">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-link="cstProduct">Produk</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-link="cstCustomer">Pelanggan</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-link="salesOrder">Sales Order</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-link="logistic">Logistik</a>
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