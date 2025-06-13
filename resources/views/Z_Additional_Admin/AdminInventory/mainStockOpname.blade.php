<section class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="displayStockOpname"></div>
        </div>
    </div>
</section>

<script>
    $(function(){
        $("#displayStockOpname").load("{{route('sales')}}/displayStockOpname");
    })
</script>