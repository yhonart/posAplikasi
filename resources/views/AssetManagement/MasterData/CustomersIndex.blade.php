<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Master Data Pelanggan</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">            
        <div class="row">
            <div class="col-12">
                <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Customers')}}/AddCustomers">Tambah Pelanggan</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="searchCustomer" id="searchCustomer" class="form-control" placeholder="Cari nama pelanggan" autofocus>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        @include('Global.global_spinner')
                        
                        <div id="displayTableCustomers"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Customers')}}",
            tableData = "TableDataCustomer",
            displayData = $("#displayTableCustomers");

        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>