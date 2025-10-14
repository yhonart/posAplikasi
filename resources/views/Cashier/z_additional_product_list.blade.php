<div class="row mb-2">
    <div class="col-md-3">
        <input type="text" class="form-control form-control-md font-weight-bold" name="billingNumber" id="billingNumber" value="{{$billNumber}}" readonly>
    </div>    
    <div class="col-md-3 col-6">
        <button type="button" id="bayarTransaksi" class="btn bg-purple font-weight-bold btn-lg btn-block btn-flat">BAYAR</button>
    </div>
    <div class="col-md-3 col-6">
        <button type="button" id="batalTransaksi" class="btn bg-light font-weight-bold btn-lg btn-block btn-flat">BATAL</button>
    </div>
</div>
<table class="table table-bordered table-hover text-nowrap text-xs">
    <thead>
        <tr class="bg-secondary">
            <th style="width: 10px">No</th>
            <th>Nama Produk</th>
            <th style="width: 20px">Qty</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Stock</th>
            <th style="width: 100px">Tambah</th>
        </tr>
    </thead>
    <tbody>
        <form id="formInputBarangKasir">
            <tr data-id="idForm">
                <input type="hidden" name="transNumber" id="transNumber" value="{{$billNumber}}">
                <input type="hidden" name="prodName" id="prodName" autocomplete="off" list="browsers">
                <input type="hidden" name="prodNameHidden1" id="prodNameHidden1">
                <input type="hidden" name="hargaModal" id="hargaModal">
                <input type="hidden" name="hargaBeli" id="hargaBeli">
                <input type="hidden" name="formStockAwal" id="formStockAwal">
                <input type="hidden" name="stockID" id="stockID">
                <input type="hidden" name="cusGroup" id="cusGroup">
                <td colspan="2" class="p-0">
                    <input type="text" class="form-control form-control-sm form-control-border border-width-2" name="fieldProduk" id="fieldProduk" placeholder="Scan Barcode Disini" autocomplete="off">
                    <input type="text" class="form-control form-control-sm form-control-border" name="disProduk" id="disProduk" style="display: none;" readonly>
                </td>
                <td class="p-0">
                    <input type="number" name="formQty" id="formQty" class="form-control form-control-sm form-control-border border-width-2" autocomplete="off">
                </td>
                <td class="p-0">
                    <input type="text" id="formSatuan" class="form-control  form-control-sm form-control-border border-width-2" readonly>
                </td>
                <td class="p-0">
                    <input type="text" name="formHargaSatuan" id="formHargaSatuan" class="form-control form-control-sm form-control-border border-width-2" readonly>
                </td>
                <td class="p-0">
                    <input type="text" name="formJumlah" id="formJumlah" class="form-control form-control-sm form-control-border border-width-2" readonly>
                </td>
                <td class="p-0">
                    <input type="hidden" name="formStockHidden" id="formStockHidden" class="form-control form-control-sm" readonly>
                    <input type="text" name="formStock" id="formStock" class="form-control form-control-sm form-control-border border-width-2" readonly>
                </td>
                <td class="p-0">
                    <button class="btn btn-sm btn-success btn-flat btn-block" id="btnSubmitItemCashier"><i class="fa-solid fa-circle-check"></i></button>
                </td>
            </tr>
        </form>
    </tbody>
</table>
<input type="hidden" name="removeAutofocus" id="removeAutofocus">
<div id="loadProductList" style="display: none;">
    <div class="spinner-grow spinner-grow-sm text-danger" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <span>Please Wait ....</span>
</div>
<div id="tableSelectProduk"></div>

<script type="text/javascript">
    $(function(){
        $("#fieldProduk").val(null).focus();
    })
    $(document).ready(function(){
        let keyword = '0',
            timer_cari_equipment = null,
            trxNumber = "{{$billNumber}}";

        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct");
        loadTableData(trxNumber);
        document.addEventListener('keydown', function(event) {  
            if (event.key === 'F3') {
                event.preventDefault();
                $("#fieldProduk").val("").focus();
            }
        });
        $("#fieldProduk").keyup(function (e) {
            e.preventDefault();
            clearTimeout(timer_cari_equipment); 
            timer_cari_equipment = setTimeout(function(){                
                let keyword = $("#fieldProduk").val().trim();
                if(keyword == ''){
                    keyword = '0';
                }
            searchData(keyword)                         
        }, 700)
        });
        function searchData(keyword){  
            // alert (keyword);
            let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct");
            if (keyword === '0' || keyword === '') {
                $("#tableSelectProduk").fadeOut("slow");
            }
            else{
                $("#loadProductList").fadeIn();
                $("#tableSelectProduk").fadeIn("slow");
                $.ajax({
                    type : 'get',
                    url : "{{route('Cashier')}}/cariProduk/"+keyword+"/"+trxNumber,
                    success : function(response){
                        $("#loadProductList").fadeOut();                        
                        $("#formQty").val(null).focus();
                        $("#tableSelectProduk").html(response);                            
                    }
                });
            }
        } 

        function loadTableData(trxNumber){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/listTableTransaksi/"+trxNumber,
                success : function(response){                
                    $("#trLoadProduct").html(response);
                }
            });
        }

    })
</script>