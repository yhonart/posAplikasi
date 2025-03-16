<table class="table table-sm table-valign-middle table-head-fixed table-striped">
    <thead>
        <tr>
            <th style="width:30%">Nama Barang [F3]</th>
            <th style="width:10%">Qty</th>
            <th style="width:10%">Satuan</th>
            <th style="width:10%">Hrg. Satuan</th>
            <th style="width:10%">Disc</th>
            <th style="width:10%">Jumlah</th>
            <th style="width:10%">Stock</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        <form id="formInputProduct">
            <input type="hidden" name="createdBy" value="{{Auth::user()->name}}">
            <input type="hidden" name="transNumber" value="{{$billNumber}}">
            <tr>
                <td>
                    <select name="productName" id="productName" class="form-control form-control-sm select2">
                        <option value="0"></option>
                        @foreach($productList as $pL)
                            <option value="{{$pL->idm_data_product}}">
                                {{$pL->product_name}}
                            </option>
                        @endforeach
                    </select>                    
                </td>
                <td><input type="number" name="qty" id="qty" class="form-control-plaintext form-control-sm quantity" autocomplete="off"></td>
                <td>
                    <select name="satuan" id="satuan" class="form-control form-control-sm satuan">
                        <option value="0"></option>                        
                    </select>
                </td>
                <td><input type="text" name="hargaSatuan" id="hargaSatuan" class="form-control-plaintext form-control-sm price-text" readonly></td>
                <td><input type="text" name="disc" id="disc" class="form-control-plaintext form-control-sm" readonly></td>
                <td><input type="text" name="jumlah" id="jumlah" class="form-control-plaintext form-control-sm" readonly></td>
                <td><input type="text" name="stock" id="stock" class="form-control-plaintext form-control-sm" readonly></td>
                <td><button class="btn btn-success elevation-1 btn-sm btn-block font-weight-bold">[F4]</button></td>
            </tr>
        </form>
    </tbody>
    <tbody id="trLoadProduct"></tbody>
</table>
<script>    
    
    $(function () {        
        $('.select2').select2({
            theme: 'bootstrap4',
        });
    });
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.price-text').mask('000.000.000', {reverse: true});
        loadTableData(urlListCashier);
        let hargaSatuan = document.getElementById("hargaSatuan"),
            discount = document.getElementById("disc"),
            jumlah = document.getElementById("jumlah"),
            stock = document.getElementById("stock");

        $("#productName").change(function () {
            let prdID = $(this).find(":selected").val();             
            $(".satuan").load(urlListCashier + '/productList/satuan/' + prdID);
        });
        
        $("#satuan").change(function () {
            let satuanUnit = $(this).find(":selected").val(),
                prdID = $("#productName").find(":selected").val();
                
                // FATCH DATA SATUAN
                fetch(urlListCashier + '/productList/hargaSatuan/' + satuanUnit + '/' + prdID)
                .then(response => response.json())
                .then(data => {                    
                    if ((data.price) || (data.discount)) {
                        hargaSatuan.value = accounting.formatMoney(data.price,"",0);
                        discount.value = data.discount + "%";

                        //Menghitung Jumlah
                        let qtyVal = $("#qty").val(),
                            priceVal = data.price,
                            discVal = data.discount;

                        $("#jumlah").val(accounting.formatMoney(priceVal * qtyVal,"",0));
                    } else {
                        hargaSatuan.value = "0";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

                // FATCH DATA STOCK 
                fetch(urlListCashier + '/productList/stockBarang/' + satuanUnit + '/' + prdID)
                .then(response => response.json())
                .then(data => {                    
                    if (data.stock) {
                        stock.value = data.stock;
                    } else {
                        stock.value = "0";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

    });

    document.addEventListener('keydown', function(event) {        
        if (event.key === 'F3') { // Menampilkan modal bantuan
            event.preventDefault();
            var selectField = document.getElementById('productName');
            selectField.focus();
        }   

        if (event.key === 'F4') {
            event.preventDefault();
            let postCreated = $("input[name=createdBy]").val(),
                postTrnNumber = $("input[name=transNumber]").val(),
                postPrdName = $("#productName").find(":selected").val();
                postQty = $("input[name=qty]").val(),
                postSatuan = $("#satuan").find(":selected").val();
                postHarga = $("input[name=hargaSatuan]").val(),
                postDisc = $("input[name=disc]").val(),
                postJumlah = $("input[name=jumlah]").val(),
                postStock = $("input[name=stock]").val();
    
            let postData = {created:postCreated, trnNumber:postTrnNumber, prdName:postPrdName, qty:postQty, satuan:postSatuan, harga:postHarga, disc:postDisc, jumlah:postJumlah, stock:postStock};
            sendData(postData);             
        }  
    });
    
    let urlProductList = "productList",
        panelProductList = $("#mainListProduct"),
        urlButtonForm = "buttonAction",
        panelButtonForm = $("#mainButton");
        
    function sendData(postData) {
        $.ajax({
            type : 'post',
            url : urlListCashier + '/productList/postProduct',
            data :  postData,
            success : function(data){
                cashier_style.load_productList(urlListCashier,urlProductList,panelProductList);
                cashier_style.load_buttonForm(urlListCashier,urlButtonForm,panelButtonForm);
                loadTableData(urlListCashier);
            }
        });
    }
    function loadTableData(urlListCashier){
        $.ajax({
            type : 'get',
            url : urlListCashier + '/productList/listTableTransaksi',
            success : function(response){                
                $("#trLoadProduct").html(response);
            }
        });
    }
    
    
</script>