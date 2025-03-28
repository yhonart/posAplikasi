<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Pengaturan Harga Utama</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="card-body text-xs"> 
        <div class="row">
            <div class="col-12 blue-alert p-2 rounded rounded-2 mb-2">
                <span class="font-weight-bold"><i class="fa-solid fa-circle-info"></i> Harga yang dimasukkan akan menjadi harga utama yang digunakan pada saat ransaksi</span>
            </div>
        </div>
        <form id="FormAddProductPrice">
            <input type="hidden" name="productID" id="productID" value="{{$editProduct->idm_data_product}}">
            <input type="hidden" name="userName" id="userName" value="{{ Auth::user()->name }}">
            <div class="row">
                <div class="col-4">
                    <span class=" font-weight-bold text-muted"><i class="fa-solid fa-cart-shopping"></i> Harga Pembelian</span>
                </div>
                <div class="col-8"><hr></div>
            </div>
            <div class="form-group row text-right">
                <label for="priceLg" class="form-label col-md-4">HPP <small>(Sat. Besar)</small></label>
                <div class="col-md-4">
                    <input type="text" name="priceLg" id="priceLg" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="priceMd" class="form-label col-md-4">HPP <small>(Sat. Kecil)</small></label>
                <div class="col-md-4">
                    <input type="text" name="priceMd" id="priceMd" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="priceSm" class="form-label col-md-4">HPP <small>(Sat. Terkecil)</small></label>
                <div class="col-md-4">
                    <input type="text" name="priceSm" id="priceSm" class="form-control form-control-sm">
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <span class=" font-weight-bold text-muted"><i class="fa-solid fa-cash-register"></i> Harga Jual</span>
                </div>
                <div class="col-8"><hr></div>
            </div>
            <div class="form-group row text-right">
                <label for="sellPriceLg" class="form-label col-md-4">Hrg. Jual <small>(Sat. Besar)</small></label>
                <div class="col-md-4">
                    <input type="text" name="sellPriceLg" id="sellPriceLg" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="sellPriceMd" class="form-label col-md-4">Hrg. Jual <small>(Sat. Kecil)</small></label>
                <div class="col-md-4">
                    <input type="text" name="sellPriceMd" id="sellPriceMd" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row text-right">
                <label for="sellPriceSm" class="form-label col-md-4">Hrg. Jual <small>(Sat. Terkecil)</small></label>
                <div class="col-md-4">
                    <input type="text" name="sellPriceSm" id="sellPriceSm" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Save</button>
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

        $("form#FormAddProductPrice").submit(function(event){
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