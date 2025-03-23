<div class="table-responsive">
    <table class="table table-sm table-valign-middle text-nowrap">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Warehouse</th>
                <th>Qty</th>
                <th>Hrg.Satuan</th>
                <th>Point</th>
                <th>Stock Awal</th>
                <th>Stock Akhir</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="hidden" name="idLo" id="idLo">
                    <input type="hidden" name="recive" id="recive">
                    <input type="hidden" name="unit" id="unit">
                    <input type="hidden" name="hiddenProdukID" id="hiddenProdukID">                    
                    <select name="produk" id="produk" class="form-control form-control-sm">
                        <option value="0"> === </option>
                        @foreach($listProduk as $lp)
                            <option value="{{$lp->productID}}">{{$lp->product_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="satuan" id="satuan" class="form-control form-control-sm form-control-border">
                        <option value="0"> === </option>
                    </select>
                </td>
                <td>
                    <select name="warehouse" id="warehouse" class="form-control form-control-sm form-control-border">
                        <option value="0">  </option>
                        @foreach($warehouse as $wh)
                            <option value="{{$wh->idm_site}}">{{$wh->site_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="qty" id="qty" class="form-control form-control-sm form-control-border" autocomplete="off">
                </td>            
                <td>
                    <input type="text" name="hrgSatuan" id="hrgSatuan" class="form-control form-control-sm form-control-border">
                </td>
                <td>
                    <input type="text" name="point" id="point" class="form-control form-control-sm form-control-border">
                </td>
                <td>
                    <input type="text" name="stockAwal" id="stockAwal" class="form-control form-control-sm form-control-border" readonly>
                </td>
                <td>
                    <input type="text" name="stockAkhir" id="stockAkhir" class="form-control form-control-sm form-control-border">
                </td>
                <td>
                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm form-control-border">
                </td>
            </tr>
        </tbody>
        <tbody id="tableItemNonInvoice"></tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        $("#produk").focus();
        let qtyBeli = document.getElementById("qty"),
            satuan = document.getElementById("satuan"),
            warehouse = document.getElementById("warehouse"),
            satuanHrg = document.getElementById("hrgSatuan");
        
        $("#produk").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('returnItem')}}/productActionNonInv/" + productID,
                success : function(response){  
                    $("#satuan").html(response);
                }
            });

            let thisWarehouse = $("#warehouse").val(),
                satuan = $("#satuan").val();

            fetch("{{route('returnItem')}}/warehouseSelected/" + thisWarehouse + "/" + productID + "/" + satuan)
            .then(response => response.json())
            .then(data => {
                if (data.hrgSatuan || data.stockAwal) {
                    satuanHrg.value = accounting.formatMoney(data.hrgSatuan,{
                        symbol: "",
                        precision: 0,
                        thousand: ".",
                    });
                    $("#stockAwal").val(data.stockAwal);                                  
                }
                $("#satuan").focus();
            });
        });
        
        $("#warehouse").change(function(){
            let thisWarehouse = $(this).find(":selected").val(),
                productID = $("#produk").val(),
                satuan = $("#satuan").val();

            fetch("{{route('returnItem')}}/warehouseSelected/" + thisWarehouse + "/" + productID + "/" + satuan)
            .then(response => response.json())
            .then(data => {
                if (data.hrgSatuan || data.stockAwal) {
                    satuanHrg.value = accounting.formatMoney(data.hrgSatuan,{
                        symbol: "",
                        precision: 0,
                        thousand: ".",
                    });
                    $("#stockAwal").val(data.stockAwal);                                  
                }
                $("#qty").focus();
            });
        });

        satuan.addEventListener("change", function(){
            let productID = $("#produk").val(),
                thisWarehouse = $("#warehouse").val(),
                satuan = $("#satuan").val();            

            fetch("{{route('returnItem')}}/warehouseSelected/" + thisWarehouse + "/" + productID + "/" + satuan)
            .then(response => response.json())
            .then(data => {
                if (data.hrgSatuan || data.stockAwal) {
                    satuanHrg.value = accounting.formatMoney(data.hrgSatuan,{
                        symbol: "",
                        precision: 0,
                        thousand: ".",
                    });
                    $("#stockAwal").val(data.stockAwal);  
                    $("#warehouse").focus();                                
                }
            });
        });

        $("#qty").on('input', computePoint);
        $("#hrgSatuan").on('input', computePoint);

        function computePoint(){
            let inputQty = $("#qty").val(),
                valHrgSatuan = $("#hrgSatuan").val(),
                ReplaceHrgSatuan = valHrgSatuan.replace(/\./g, ""),
                valStockAwal = $("#stockAwal").val();

            if (typeof inputQty == "undefined" || typeof inputQty == "0") {
                return
            }

            let point = parseInt(ReplaceHrgSatuan) * parseInt(inputQty),
                stockAkhir = parseInt(valStockAwal) - parseInt(inputQty);

            $("#point").val(accounting.formatMoney(point,{
                symbol: "",
                precision: 0,
                thousand: ".",
            }));
            $("#stockAkhir").val(stockAkhir);
        }

        var activitiesQty = document.getElementById("qty"),
            activitiesHarga = document.getElementById("hrgSatuan"),
            activitiesStockAkhir = document.getElementById("stockAkhir");

        activitiesQty.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        activitiesHarga.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        activitiesStockAkhir.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });

        function addActivityItem (){
            // Get value
            let productID = $("#produk").val(),
                satuan = $("#satuan").val(),
                warehouse = $("#warehouse").val(),
                qty = $("#qty").val(),
                hrgSatuan = $("#hrgSatuan").val(),
                point = $("#point").val(),
                stockAwal = $("#stockAwal").val(),
                stockAkhir = $("#stockAkhir").val(),
                keterangan = $("#keterangan").val(),
                returnNumber = "{{$returnNumber}}",
                supplierID = "{{$supplierID}}";

            let dataForm = {productID:productID, satuan:satuan, warehouse:warehouse, qty:qty, hrgSatuan:hrgSatuan, point:point,
                stockAwal:stockAwal, stockAkhir:stockAkhir, keterangan:keterangan, returnNumber:returnNumber, supplierID:supplierID
            }

            sendData(dataForm, returnNumber);
        }

        function sendData(dataForm, returnNumber){            
            $.ajax({
                type : 'post',
                url : "{{route('returnItem')}}/postItemReturnNonInvoice",
                data :  dataform,
                success : function(data){                  
                    getDataReturNonInvoice(returnNumber);
                }
            });
        }

        function getDataReturNonInvoice(returnNumber){
            $.ajax({
                type : 'get',
                url : "{{route('returnItem')}}/purchasingList/itemReturnNonInv/"+returnNumber,
                success : function(response){
                    $("#tableItemNonInvoice").html(response);
                }
            });
        }
    });
</script>