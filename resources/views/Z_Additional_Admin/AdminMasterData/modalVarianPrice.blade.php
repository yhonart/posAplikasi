<form id="varianPriceForm">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Varian Price Code</label>
                <input type="text" class="form-control form-control-sm" name="varianCode" id="varianCode">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Price</label>
                <input type="text" class="form-control form-control-sm" name="price" id="price">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <button type="button" class="btn btn-sm btn-success" id="saveVarianPrice">Simpan</button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        
        $("#saveVarianPrice").on('click', function(){
            let valVarianCode = $("#varianCode").val(),
                valPrice = $("#price").val(),
                id = "{{$id}}";
            $.ajax({
                type : 'post',
                url : "{{route('sales')}}/mainProduct/newProduct/postNewVarian",
                data :  {valCode:valVarianCode, valPrice:valPrice, valID:id},
                success : function(data){      
                    if (data.warning) {
                        alertify
                        .alert(data.warning, function(){
                            alertify.message('OK');
                        }).set({title:"Warning"});
                    }
                    else if (data.success) {
                        alertify.message(data.success);
                    }
                    else{
                        alertify.message(data.success);
                    }
                }
            }); 
        })
    });
</script>