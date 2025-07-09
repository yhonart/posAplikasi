<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="form-group row multi-field">
                    <input type="hidden" name="cusCode" id="cusCode" value="{{$cusCode}}">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Produk </label>
                    <div class="col-sm-2">
                        <select name="produk" id="produk" class="form-control form-control-sm">
                            <option value="0">--- Pilih ---</option>                        
                            @foreach($product as $pList)
                                <option value="{{$pList->idm_data_product}}">{{$pList->product_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" class="form-control form-control-sm" name="qtyOrder" id="qtyOrder" autocomplete="off" placeholder="Jumlah Order">
                    </div>                  
                    <button type="button" class="btn btn-info btn-flat add-field" id="addProduk"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#addProduk").on('click', function(){
            let productID = $("#produk").val(),
                qtyOrder = $("#qtyOrder").val(),
                cusCode = "{{$cusCode}}";

            let dataAddProduk = {productID : productID, qtyOrder : qtyOrder, cusCode : cusCode};
            $.ajax({
                type : 'post',
                url : "{{route('sales')}}/configCustomer/aturPenjualan/addOrder/postOrder",
                data :  dataAddProduk,
                success : function(data){                    
                    alertify.success('Produk Tersimpan');
                }
            });
        });
    });
</script>