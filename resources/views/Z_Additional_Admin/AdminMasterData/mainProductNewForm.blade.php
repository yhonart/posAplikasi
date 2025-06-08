<div class="row">
    <div class="col-md-12">
        <div class="card card-body shadow">            
            <form id="newProductForm">
                <input type="hidden" name="productID" id="productID" value="{{$nextID}}">
                <div class="form-group row">
                    <label for="" class="col-md-4">Product Code</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="productCode" id="productCode" readonly value="{{$prdCode}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Product Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="productName" id="productName">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Product Category</label>
                    <div class="col-md-4">
                        <select name="productCategory" id="productCategory" class="form-control form-control-sm">
                            <option value="0"></option>
                            @foreach($prdCategory as $pct)
                            <option value="{{$pct->category_name}}">{{$pct->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Set Minimum Stock</label>
                    <div class="col-md-4">
                        <input type="number" class="form-control form-control-sm" name="minimumStock" id="minimumStock">
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
                    <button type="button" class="btn btn-sm btn-success font-weight-bold">Save</button>
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
        $("form#newProductForm").submit(function(event){
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