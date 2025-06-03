@extends('layouts.frontpage')
@section('content')
<div class="content mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

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