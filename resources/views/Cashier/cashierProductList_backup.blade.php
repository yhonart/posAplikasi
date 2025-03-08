<!--<p class="bg-danger p-1">Halaman ini sedang proses perbaikan 🙏</p>-->
<table class="table table-sm table-valign-middle table-head-fixed table-hover " id="mainTablePrdList">
    <thead class="text-center">
        <tr>
            <th width="5%">No</th>
            <th width="20%">Nama Barang [F3]</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Hrg.Satuan</th>
            <th>Disc</th>
            <th>Jumlah</th>
            <th>Stock Barang</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="trLoadProduct"></tbody>
    <tbody id="trInputProdut">
        <form id="formInputBarangKasir">
            <input type="hidden" name="createdBy" id="createdBy" value="{{Auth::user()->name}}">
            <input type="hidden" name="transNumber" id="transNumber" value="{{$billNumber}}">
            <input type="hidden" name="prodName" id="prodName" autocomplete="off" list="browsers">
            <input type="hidden" name="prodNameHidden1" id="prodNameHidden1">
            <input type="hidden" name="hargaModal" id="hargaModal">
            <tr>
                <td colspan="2" class="p-0">
                    <select name="prodNameHidden" id="prodNameHidden" class="form-control form-control-sm" style="width: 100%">
                        <option value="0" readonly>Tekan ENTER</option>
                        @foreach($productList as $pL)
                            <option value="{{$pL->idm_data_product}}">{{$pL->product_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="p-0"><input type="number" name="qty" id="qty" class="form-control  quantity prd-input form-control-sm" autocomplete="off"></td>
                <td class="p-0">
                    <select name="satuan" id="satuan" class="form-control  satuan prd-input form-control-sm">
                        <option value="0"></option>
                    </select>
                </td>
                <td class="p-0"><input type="text" name="hargaSatuan" id="hargaSatuan" class="form-control  price-text prd-input form-control-sm" readonly></td>
                <td class="p-0"><input type="text" name="disc" id="disc" class="form-control  prd-input form-control-sm" autocomplete="off"></td>
                <td class="p-0"><input type="text" name="jumlah" id="jumlah" class="form-control  prd-input form-control-sm" readonly></td>
                <td class="p-0">
                    <input type="hidden" name="stockHidden" id="stockHidden" class="form-control  form-control-sm" readonly>
                    <input type="text" name="stock" id="stock" class="form-control  prd-input form-control-sm" readonly>
                </td>
                <td></td>
            </tr>
        </form>
    </tbody>
</table>
<script type="text/javascript">
    $(function () {        
        $('#prodNameHidden').select2({
            width: 'resolve',
        });
        
        $("#prodNameHidden").val(null).focus();
        loadTableData();
    });   

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('.price-text').mask('000.000.000', {
            reverse: true,
            translation: {
                'S': {
                    pattern: /-/,
                    optional: true
                }
            }
        });
        
        $("#disc").mask("S##.###.###", {
            translation: {
                'S': {
                    pattern: /-/,
                    optional: true
                }
            }
        });
        
        let hargaSatuan = document.getElementById("hargaSatuan"),
            hargaModal = document.getElementById("hargaModal"),
            discount = document.getElementById("disc"),
            jumlah = document.getElementById("jumlah"),
            stock = document.getElementById("stock"),
            qty = document.getElementById('qty'),
            satuan = document.getElementById('satuan'),
            countBill = "{{$countBill}}";
            
        var routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct");
            
            
        $("#prodNameHidden").change(function(){
            let productID = $(this).find(":selected").val(),
                transNumber = $("#transNumber").val();
            
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/satuan/" + productID,
                success : function(response){  
                    $("#satuan").html(response);
                }
            });

            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/addTmpTrx/" + productID + "/" + transNumber,
                success : function(response){  
                    $("#qty").val("1").focus().select();
                }
            });

            fetch("{{route('Cashier')}}/productList/prdResponse/" + productID)
            .then(response => response.json())
            .then(data => {                    
                if ((data.price) || (data.discount) || (data.prdStock) || (data.hrgModal)) {
                    hargaSatuan.value = accounting.formatMoney(data.price,{
                        symbol: "",
                        precision: 0,
                        thousand: ".",
                    });
                    discount.value = data.discount;
                    hargaModal.value = data.hrgModal;
                    //Menghitung Jumlah
                    let qtyVal = '1',
                        priceVal = data.price,
                        discVal = data.discount;
                    $("#jumlah").val(accounting.formatMoney(priceVal * qtyVal,{
                        symbol: "",
                        precision: 0,
                        thousand: ".",
                    }));
                    // $("#qty").val("1").focus().select();
                    $("#stock").val(data.prdStock);
                    $("#stockHidden").val(data.prdStock-qtyVal);
                } else {
                    hargaSatuan.value = "0";
                }
                
            })
            .catch(error => {
                console.error('Error:', error);
            });
        })
        
        satuan.addEventListener("change", function() {
            let satuanUnit = $(this).find(":selected").val(),
                prdID = $("#prodNameHidden").val();
                // alert(countBill);
            if (satuanUnit !== "0") {                
                // FATCH DATA SATUAN
                if (satuanUnit !== undefined){  
                    if (countBill === '0'){
                        toastr.error('Harap create customer terlebih dahulu !')
                    }
                    else{
                        fetch("{{route('Cashier')}}/productList/hargaSatuan/" + satuanUnit + "/" + prdID)
                        .then(response => response.json())
                        .then(data => {                    
                            if ((data.price) || (data.discount)) {
                                hargaSatuan.value = accounting.formatMoney(data.price,{
                                    symbol: "",
                                    precision: 0,
                                    thousand: ".",
                                });
                                discount.value = data.discount;
        
                                //Menghitung Jumlah
                                let qtyVal = $("#qty").val(),
                                    priceVal = data.price,
                                    discVal = data.discount;
                                
                                computeJumlah();
                                
                                $("#disc").val("0").focus().select();
                            } else {
                                hargaSatuan.value = "0";
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                }
    
                // MENAMPILKAN DATA STOCK
                if (satuanUnit !== undefined){
                    fetch("{{route('Cashier')}}/productList/stockBarang/" + satuanUnit + '/' + prdID)
                    .then(response => response.json())
                    .then(data => {                    
                        let readyStock = data.stock,
                            qtyVal = $("#qty").val();
                        $("#stock").val(readyStock);
                        $("#stockHidden").val(readyStock-qtyVal);
                        qty.addEventListener("change", updateQtyValue);
                        // if (data.stock) {
                        // } else {
                        //     alertify
                        //       .alert("Tidak ada stok barang di sistem, silahkan hubungi admin untuk koreksi stok barang !", function(){
                        //         alertify.message('OK');
                        //         cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                        //       }).set({title:"INFO STOCK"});
                        //     stock.value = "0";
                        // }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
                
                function updateQtyValue(e){
                    let priceVal = $("#hargaSatuan").val().replaceAll(".", ""),
                            qtyVal = e.target.value,
                            inputJumlahVal = priceVal * qtyVal;
                        $("#jumlah").val(accounting.formatMoney(inputJumlahVal,{
                            symbol: "",
                            precision: 0,
                            thousand: ".",
                        }));
                        $("#stock").val(readyStock - qtyVal+" / "+readyStock);
                        $("#stockHidden").val(readyStock - qtyVal);
                        // alert(priceVal + "," + qtyVal + "," + inputJumlahVal); 
                }
            }
            else{
                $("#hargaSatuan").val('0');
                $("#disc").val('0');
                $("#jumlah").val('0');
                $("#stock").val('0');
            }
               
        });
        //INPUT DISCOUNT
        $("#disc").on('input', computeDisc);
        function computeDisc(){
            let valHrgSatuan = $("#hargaSatuan").val(),
                valQty = $("#qty").val(),
                valDisc = $("#disc").val(), 

                inputHrgSatuan = valHrgSatuan.replace(/\./g, ""),
                inputQty = valQty.replace(/\./g, "");
                inputDisc = valDisc.replace(/\./g, "");

            if (typeof inputDisc == "undefined" || typeof inputDisc == "0") {
                return
            }
            // alert(percBilling);
            
            // let beforeDisc = parseInt(inputHrgSatuan) - parseInt(inputQty);
            let hrgAfterDis = parseInt(inputHrgSatuan) - parseInt(inputDisc);
            $("#jumlah").val(accounting.formatMoney(hrgAfterDis*inputQty,{
                symbol: "",
                precision: 0,
                thousand: ".",
            })); 
        }
        
        $("#qty").on('input', computeJumlah);
        function computeJumlah(){
            let qtyVal = $("#qty").val(),
                stockVal = $("#stock").val(),
                valPriceUnit = $("#hargaSatuan").val(),
                priceVal = valPriceUnit.replace(/\./g, "");
            // alert (qtyVal);
            $("#jumlah").val(accounting.formatMoney(priceVal * qtyVal,{
                symbol: "",
                precision: 0,
                thousand: ".",
            }));
            $("#stockHidden").val(stockVal - qtyVal);
        }
        
        
        document.addEventListener('keydown', function(event) {  
            if (event.key === 'F3') {
                event.preventDefault();
                $("#prodNameHidden").val("").focus();
            }
        });
        
        var activities = document.getElementById("disc");
        var actqty = document.getElementById("qty");
        var actsat = document.getElementById("satuan");
        var actJumlah = document.getElementById("jumlah");
        var actDisc = document.getElementById("stock");
        
        activities.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        actJumlah.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        actDisc.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        
        var $inp = $(".prd-input");
        $inp.on({
            
            keydown: function(ev) {
                var i = $inp.index(this);
                if(ev.which===8 && !this.value && i) {
                    $inp.eq(i - 1).focus();
                }
            }
        });
        
    });
    function addActivityItem() {
        let postCreated = $("#createdBy").val(),
            postTrnNumber = $("#transNumber").val(),
            postPrdName = $("#prodNameHidden").val(),
            postQty = $("#qty").val(),
            postSatuan = $("#satuan").find(":selected").val(),
            postHarga = $("input[name=hargaSatuan]").val(),
            postDisc = $("input[name=disc]").val(),
            postJumlah = $("input[name=jumlah]").val(),
            postStock = $("input[name=stockHidden]").val();
        // let dataform = new FormData(document.getElementById("v"));
        
        let dataform = {createdBy:postCreated, transNumber:postTrnNumber, prodNameHidden:postPrdName, qty:postQty, satuan:postSatuan, hargaSatuan:postHarga, disc:postDisc, jumlah:postJumlah, stock:postStock};
        sendData(dataform);
        
        //alert(postQty);
    }


    function sendData(dataform) {
        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");
        let billCode = "{{$billNumber}}";
        $.ajax({
            type : 'post',
            url : "{{route('Cashier')}}/productList/postProduct",
            data :  dataform,
            success : function(data){                  
                loadTableData();
                totalBelanja(billCode);
                cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
            }
        });
    }
    function loadTableData(){
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/productList/listTableTransaksi",
            success : function(response){                
                $("#trLoadProduct").html(response);
            }
        });
    }
        
    function totalBelanja(billCode){
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/buttonAction/updateTotalBeanja/"+billCode,
            success : function(response){
                $('#totalBelanja').html(response);
            }
        });
    }
</script>