<form id="formVarianFixed">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="firstNameCode">First Code</label>
                <input type="text" name="firstNameCode" id="firstNameCode" class="form-control form-control-sm" placeholder="Kode Nama Depan, Ex:ABC">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="countVariantPrice">Count Variant Price</label>
                <input type="text" name="countVariantPrice" id="countVariantPrice" class="form-control form-control-sm" placeholder="Ex: 20">
                <small>Jumlah varian harga yang akan dimasukkan</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="minimumPrice">Minimum Price</label>
                <input type="text" name="minimumPrice" id="minimumPrice" class="form-control form-control-sm" placeholder="Ex:1000">
                <small>Start Harga Paling Rendah</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="difference">Difference</label>
                <input type="text" name="difference" id="difference" class="form-control form-control-sm" placeholder="Ex:5000">
                <small>Selisih harga yang akan dimasukkan</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-success" id="posVarianFixed">Save</button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        
        $("#posVarianFixed").on('click', function(){
            let valInitialCode = $("#firstNameCode").val(),
                valCount = $("#countVariantPrice").val(),
                valMinimum = $("#minimumPrice").val(),
                valDifference = $("#difference").val(),
                id = "{{$id}}";
            $.ajax({
                type : 'post',
                url : "{{route('sales')}}/mainProduct/newProduct/postNewVarianFixed",
                data :  {valInit:valInitialCode,valCount:valCount,valMinimum:valMinimum,valDif:valDifference,id:id},
                success : function(data){      
                    if (data.warning) {
                        alertify
                        .alert(data.warning, function(){
                            alertify.message('OK');
                        }).set({title:"Warning"});
                    }
                    else if (data.success) {
                        alertify.message(data.success);
                        $("#varianPriceForm")[0].reset();
                    }
                    else{
                        $("#varianPriceForm")[0].reset();
                        alertify.message(data.success);
                    }
                    $("#divTableVarianHarga").load("{{route('sales')}}/mainProduct/newProduct/tableVarianPrice/"+id);
                }
            }); 
        })
    });
</script>