<div class="row">
    <div class="col-md-12">
        <div class="card card-body shadow">            
            <form id="newProductForm">
                <input type="text" name="productID" id="productID" value="{{$nextID}}">
                <div class="form-group row">
                    <label for="" class="col-md-4">Kode Produk</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="productCode" id="productCode">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Nama Produk</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="productName" id="productName">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Kategori Produk</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="productCategory" id="productCategory">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Set Minimum Stok</label>
                    <div class="col-md-4">
                        <input type="number" class="form-control form-control-sm" name="minimumStock" id="minimumStock">
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info btn-sm font-weight-bold" id="btnAddVarianHarga">Input Varian Harga</button>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="divTableVarianHarga"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

</script>