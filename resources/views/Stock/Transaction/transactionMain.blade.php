<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Data Barang</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">            
        <div class="row">
            <div class="col-12">
                <div class="btn-group">
                    <button class="btn btn-default text-info font-weight-bold ITEM-DISPLAY" id="StockBarang" data-open="StockBarang"><i class="fa-solid fa-plus"></i> Stock Barang</button>
                    <button class="btn btn-default text-info font-weight-bold ITEM-DISPLAY" id="StockOpname" data-open="StockOpname"><i class="fa-solid fa-list"></i> Stock Opname</button>
                    <button class="btn btn-default text-info font-weight-bold ITEM-DISPLAY" id="KoreksiItem" data-open="KoreksiItem"><i class="fa-solid fa-list"></i> Koreksi Item</button>
                    <button class="btn btn-default text-info font-weight-bold ITEM-DISPLAY" id="MutasiBarang" data-open="MutasiBarang"><i class="fa-solid fa-list"></i> Mutasi Barang</button>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('Global.global_spinner')
                        <div id="diplayTransaction"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('TransProduct')}}",
            tableData = "StockBarang",
            displayData = $("#diplayTransaction");
        
        $('.ITEM-DISPLAY').on('click', function (e) {
            e.preventDefault();
            let tableData = $(this).attr('data-open');
            loadSpinner.fadeOut();
            displayData.load(routeIndex+"/"+tableData);
        });
        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>