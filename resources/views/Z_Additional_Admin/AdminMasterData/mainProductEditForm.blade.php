<div class="row">
    <div class="col-md-12">
        <div class="card card-body shadow">            
            <form id="editProductForm">
                <input type="hidden" name="productID" id="productID" value="{{$dataID}}">
                <div class="form-group row">
                    <label for="" class="col-md-4">Product Code</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="productCode" id="productCode" readonly value="{{$productDetail->product_code}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Product Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="productName" id="productName" value="{{$productDetail->product_name}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Product Category</label>
                    <div class="col-md-4">
                        <select name="productCategory" id="productCategory" class="form-control form-control-sm">
                            <option value="0">{{$productDetail->product_category}}</option>
                            @foreach($prdCategory as $pct)
                                @if($pct->category_name <> $productDetail->product_category)
                                    <option value="{{$pct->category_name}}">{{$pct->category_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Set Minimum Stock</label>
                    <div class="col-md-4">
                        <input type="number" class="form-control form-control-sm" name="minimumStock" id="minimumStock" value="{{$productDetail->minimum_stock}}">
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info btn-sm font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" id="btnAddVarianHarga" href="{{route('sales')}}/mainProduct/newProduct/newPrice/{{$nextID}}">Add Varian Harga</button>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="divTableVarianHarga"></div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-success font-weight-bold">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        let idProduct = "{{$nextID}}";
        $("#divTableVarianHarga").load("{{route('sales')}}/mainProduct/newProduct/tableVarianPrice/"+idProduct)
    })
    $(document).ready(function(){
        $("form#editProductForm").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('sales')}}/mainProduct/newProduct/postNewProduct",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    if (data.warning) {
                        alertify
                        .alert(data.warning, function(){
                            alertify.message('OK');
                        });
                    }
                    else if (data.success){
                        reloadNewForm();
                    }
                },                
            });
            return false;
        });

        function reloadNewForm(){
            $.ajax({
                type : 'get',
                url : "{{route('sales')}}/mainProduct/newProduct",
                success : function(response){
                    $('#divContentProduct').html(response);
                }
            });
        }
    });
</script>