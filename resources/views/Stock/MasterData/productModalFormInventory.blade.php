<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Inventory</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="card-body">
        <form id="FormInventory">
            <input type="hidden" name="productID" id="productID" value="{{$id}}">
            <input type="hidden" name="productName" id="productName" value="{{$id}}">
            <input type="hidden" name="userName" id="userName" value="{{ Auth::user()->name }}">
            <div class="form-group row text-right">
                <label for="sku" class="form-label col-md-4">SKU</label>
                <div class="col-md-4">
                    <input type="text" name="sku" id="sku" class="form-control form-control-sm" style="text-transform:uppercase" value="{{$dataproduct->sku}}">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="StockQty" class="form-label col-md-4">Jumlah Stock</label>
                <div class="col-md-4">
                    <input type="text" name="StockQty" id="StockQty" class="form-control form-control-sm" value="{{$dataproduct->stock}}">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="MinimumStock" class="form-label col-md-4">Minimum Stock</label>
                <div class="col-md-4">
                    <input type="text" name="MinimumStock" id="MinimumStock" class="form-control form-control-sm" value="{{$dataproduct->minimum_stock}}">
                    <small class="text-info">Untuk memberikan notif di halaman dashboard anda apabila barang sudah minim.</small>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <button type="submit" id="SaveInv" class="btn btn-success font-weight-bold">Save</button>
            </div>
        </form>
        <div class="row">
            <div class="col-12 red-alert p-2 rounded rounded-2 mb-2 notive-display" style="display:none;">
                <span class="font-weight-bold" id="notiveDisplay" ></span>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Stock')}}",
            tableData = "ProductMaintenance",
            displayData = $("#displayTableCategory");

        $("form#FormInventory").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('Stock')}}/ProductMaintenance/PostInventory",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    global_style.hide_modal();
                    global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                    alertNotive.removeClass('red-alert').addClass('green-alert');
                },                
            });
            return false;
        });
    });
</script>