
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
                    <button class="btn btn-default text-info font-weight-bold ITEM-DISPLAY" id="TambahBarang" data-open="AddProduct"><i class="fa-solid fa-plus"></i> Tambah Barang</button>
                    <button class="btn btn-default text-info font-weight-bold ITEM-DISPLAY" id="ProductList" data-open="ProductMaintenance"><i class="fa-solid fa-list"></i> List Barang</button>
                    <button class="btn btn-default text-info font-weight-bold " id="Cetak2"><i class="fa-solid fa-print"></i> Cetak Barang + Harga</button>
                    <button class="btn btn-default text-info font-weight-bold " id="Cetak1"><i class="fa-solid fa-print"></i> Cetak Barang</button>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('global.global_spinner')
                        <div id="displayTableCategory"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Stock')}}",
            tableData = "ProductMaintenance",
            displayData = $("#displayTableCategory");
        
        $('.ITEM-DISPLAY').on('click', function (e) {
            e.preventDefault();
            let tableData = $(this).attr('data-open');
            loadSpinner.fadeOut();
            displayData.load(routeIndex+"/"+tableData);
        });
        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>