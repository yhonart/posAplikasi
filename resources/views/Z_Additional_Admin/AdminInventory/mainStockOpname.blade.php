<section class="container">
    <div class="row mb-2">
        <div class="col-md-12">
            <div class=" btn-group">
                <button class=" btn btn-default btn-sm border-0 font-weight-bold OPNAME-MENU" data-path="mainTableStockOpname">List Data Opname</button>
                <button class=" btn btn-default btn-sm border-0 font-weight-bold OPNAME-MENU" data-path="displayStockOpname">Input Dok.Stock Opname</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="displayStockOpname"></div>
        </div>
    </div>
</section>

<script>
    $(function(){
        $("#displayStockOpname").load("{{route('sales')}}/displayStockOpname");
    });

    $(document).ready(function() {
        $('.OPNAME-MENU').on('click', function (e) {
            e.preventDefault();
            let path = $(this).attr('data-path');

            $("#displayStockOpname").load("{{route('sales')}}/"+path);
        });    
    });

</script>