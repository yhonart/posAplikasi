<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Tambah Barang</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="card-body">        
        <form id="FormAddProductSale">            
            <input type="hidden" name="userName" id="userName" value="{{ Auth::user()->name }}">
            <input type="hidden" name="billNumber" id="billNumber" value="{{ $billNumber }}">
            <input type="hidden" name="areaGudang" id="areaGudang" value="{{ $areaID }}">
            <div class="form-group row text-right">
                <label for="productName" class="form-label col-md-4">Nama Produk</label>
                <div class="col-md-8">
                    <select name="productName" id="productName" class="form-control form-control-sm">
                        <option value="0" readonly></option>
                        @foreach($dbProductList as $dbPl)
                        <option value="{{$dbPl->idm_data_product}}">{{$dbPl->product_name}} || STOK : {{$dbPl->stock}}</option>
                        @endforeach
                    </select>                    
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="quantity" class="form-label col-md-4">Jumlah</label>
                <div class="col-md-4">
                    <input type="number" name="quantity" id="quantity" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="unit" class="form-label col-md-4">Satuan</label>
                <div class="col-md-4">
                    <input type="text" name="unit" id="unit" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="hargaSatuan" class="form-label col-md-4">Harga Satuan</label>
                <div class="col-md-4">
                    <input type="text" name="hargaSatuan" id="hargaSatuan" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="discount" class="form-label col-md-4">Discount</label>
                <div class="col-md-4">
                    <input type="text" name="discount" id="discount" class="form-control form-control-sm" value="0">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="total" class="form-label col-md-4">Total</label>
                <div class="col-md-4">
                    <input type="text" name="total" id="total" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Masukkan</button>
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
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let alertNotive = $('.notive-display');

        $("form#FormAddProductSale").submit(function(event){
            event.preventDefault();
            $.ajax({
                url : "{{route('Stock')}}/ProductMaintenance/PostNewProductPrice",
                type : 'POST',
                data : new FormData(this),
                async : true,
                cache : true,
                contentType : false,
                processData : false,
                success : function (data) {
                    $(".notive-display").fadeIn();
                    $("#notiveDisplay").html(data.success);
                    alertNotive.removeClass('red-alert').addClass('green-alert');
                }
            })
        })
    });
</script>