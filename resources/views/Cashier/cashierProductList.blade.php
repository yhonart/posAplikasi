<!-- <p class="bg-danger p-1">Halaman ini sedang proses perbaikan 🙏</p> -->
<table class="table table-sm table-valign-middle table-head-fixed table-hover table-bordered animate__animated animate__fadeIn" id="listTableItemTrx">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="20%">Nama Barang [F3]</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Hrg.Satuan</th>
            <th>Disc</th>
            <th>Jumlah</th>
            <th>Stock</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="trLoadProduct"></tbody>
    <tbody id="trInputProdut">
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
                    <input type="text" name="formDisc" id="formDisc" class="form-control form-control-sm form-control-border border-width-2" autocomplete="off" >
                </td>
                <td class="p-0">
                    <input type="text" name="formJumlah" id="formJumlah" class="form-control form-control-sm form-control-border border-width-2" readonly>
                </td>
                <td class="p-0" colspan="2">
                    <input type="hidden" name="formStockHidden" id="formStockHidden" class="form-control form-control-sm" readonly>
                    <input type="text" name="formStock" id="formStock" class="form-control form-control-sm form-control-border border-width-2" readonly>
                </td>
            </tr>
        </form>
    </tbody>
</table>
<input type="hidden" name="removeAutofocus" id="removeAutofocus">
<div id="tableSelectProduk"></div>
<script type="text/javascript">
     $(function () {   
        $("#fieldProduk").val(null).focus();
    });   
    $(document).ready(function() {
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
                $("#tableSelectProduk").fadeIn("slow");
                $.ajax({
                    type : 'get',
                    url : "{{route('Cashier')}}/cariProduk/"+keyword+"/"+trxNumber,
                    success : function(response){
                        if (response.warningCustomer) {
                            alertify
                            .alert(response.warningCustomer, function(){
                                alertify.message('OK');
                                window.location.reload();
                            }).set({title:"Alert !"});
                        }
                        else if(response.success){
                            $("#fieldProduk").val('');
                            loadTableData(trxNumber);
                            totalBelanja(trxNumber);
                            alertify.success(response.success);
                        }
                        else{
                            $("#formQty").val(null).focus();
                            $("#tableSelectProduk").html(response);                            
                        }
                    }
                });
            }
        }       

        $("#formQty").on('input', computeJumlah);
        function computeJumlah(){
            let qtyVal = $("#formQty").val(),
                stockVal = $("#formStockAwal").val(),
                valPriceUnit = $("#formHargaSatuan").val(),
                priceVal = valPriceUnit.replace(/\./g, "");
            $("#formJumlah").val(accounting.formatMoney(priceVal * qtyVal,{
                symbol: "",
                precision: 0,
                thousand: ".",
            }));
            $("#formStock").val(stockVal - qtyVal);
        }

        $("#formDisc").on('input', computeDisc);
        function computeDisc(){
            let valHrgSatuan = $("#formHargaSatuan").val(),
                valQty = $("#formQty").val(),
                valDisc = $("#formDisc").val(), 

                inputHrgSatuan = valHrgSatuan.replace(/\./g, ""),
                inputQty = valQty.replace(/\./g, "");
                inputDisc = valDisc.replace(/\./g, "");

            if (typeof inputDisc == "undefined" || typeof inputDisc == "0") {
                return
            }
            let hrgAfterDis = parseInt(inputHrgSatuan) - parseInt(inputDisc);
            $("#formJumlah").val(accounting.formatMoney(hrgAfterDis*inputQty,{
                symbol: "",
                precision: 0,
                thousand: ".",
            })); 
        }

        var qtyActivities = document.getElementById("formQty");
        var discountActivites = document.getElementById("formDisc");

        qtyActivities.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        discountActivites.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        
        function addActivityItem() {
            let stockID = $("#stockID").val(),
                cusGroup = $("#cusGroup").val(),
                qty = $("#formQty").val();
                
            let dataform = {trxNumber:trxNumber,stockID:stockID,cusGroup:cusGroup,qty:qty};
                $.ajax({
                    type : 'post',
                    url : "{{route('Cashier')}}/inputItem",
                    data :  dataform,
                    success : function(response){
                        cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                        totalBelanja(trxNumber);
                    }
                });
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
        function totalBelanja(trxNumber){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/updateTotalBeanja/"+trxNumber,
                success : function(response){
                    $('#totalBelanja').html(response);
                }
            });
        }
    });
    
</script>