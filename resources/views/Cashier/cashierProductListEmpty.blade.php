<form id="formInputProduct">
    <input type="hidden" name="createdBy" id="createdBy" value="{{Auth::user()->name}}">
    <input type="hidden" name="transNumber" id="transNumber" value="{{$billNumber}}">
    <tr>
        <td>
            <input type="search" class="form-control form-control-sm" name="prodName" id="prodName" autocomplete="off">
            <input type="hidden" class="form-control form-control-sm" name="prodNameHidden" id="prodNameHidden">
            <div id="livesearch"></div>
        </td>
        <td><input type="number" name="qty" id="qty" class="form-control form-control-sm quantity" autocomplete="off"></td>
        <td>
            <select name="satuan" id="satuan" class="form-control form-control-sm satuan">
                <option value="0"></option>                        
            </select>
        </td>
        <td><input type="text" name="hargaSatuan" id="hargaSatuan" class="form-control form-control-sm price-text" readonly></td>
        <td><input type="text" name="disc" id="disc" class="form-control form-control-sm" readonly></td>
        <td><input type="text" name="jumlah" id="jumlah" class="form-control form-control-sm" readonly></td>
        <td>
            <input type="hidden" name="stockHidden" id="stockHidden" class="form-control form-control-sm" readonly>
            <input type="text" name="stock" id="stock" class="form-control form-control-sm" readonly>
        </td>
        <td><button type="submit" class="btn btn-success elevation-1 btn-sm btn-block font-weight-bold">[F4]</button></td>
    </tr>
</form>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("#prodName").val("").focus();
        let timer_cari_equipment = null;
        $("#prodName").keyup(function (e){
            e.preventDefault();            
            let keyWord = $("#prodName").val().trim();
            if (keyWord=='') {
                keyWord = '0';
            }
            searchProduct(keyWord);
        });
        function searchProduct(keyWord){   
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/searchProduct/by/"+keyWord,
                success : function(response){
                    $("#livesearch").html(response);
                    $("#jumlah").val('0');
                }
            });
        }

        //OLD CHECK AGAIN
        
        $('.price-text').mask('000.000.000', {reverse: true});
        let hargaSatuan = document.getElementById("hargaSatuan"),
            discount = document.getElementById("disc"),
            jumlah = document.getElementById("jumlah"),
            stock = document.getElementById("stock"),
            qty = document.getElementById('qty');
        
        $("#satuan").change(function () {
            let satuanUnit = $(this).find(":selected").val(),
                prdID = $("#prodNameHidden").val();
                
            if (satuanUnit != "0") {
                
                // FATCH DATA SATUAN
                fetch("{{route('Cashier')}}/productList/hargaSatuan/" + satuanUnit + "/" + prdID)
                .then(response => response.json())
                .then(data => {                    
                    if ((data.price) || (data.discount)) {
                        hargaSatuan.value = accounting.formatMoney(data.price,"",0);
                        discount.value = data.discount + "%";

                        //Menghitung Jumlah
                        let qtyVal = $("#qty").val(),
                            priceVal = data.price,
                            discVal = data.discount;

                        $("#jumlah").val(accounting.formatMoney(priceVal * qtyVal,"",0)).focus();
                    } else {
                        hargaSatuan.value = "0";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

                // FATCH DATA STOCK 
                fetch("{{route('Cashier')}}/productList/stockBarang/" + satuanUnit + '/' + prdID)
                .then(response => response.json())
                .then(data => {                    
                    if (data.stock) {
                        let readyStock = data.stock,
                            qtyVal = $("#qty").val();
                        $("#stock").val(readyStock-qtyVal+" / "+readyStock);
                        $("#stockHidden").val(readyStock-qtyVal);

                        qty.addEventListener("change", updateQtyValue);
                        function updateQtyValue(e){
                            let priceVal = $("#hargaSatuan").val().replaceAll(",", ""),
                                qtyVal = e.target.value,
                                inputJumlahVal = priceVal * qtyVal;                                
                            $("#jumlah").val(accounting.formatMoney(inputJumlahVal,"",0));
                            $("#stock").val(readyStock - qtyVal+" / "+readyStock);
                            $("#stockHidden").val(readyStock - qtyVal);
                            // alert(priceVal + "," + qtyVal + "," + inputJumlahVal); 
                        }
                    } else {
                        stock.value = "0";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            else{
                $("#hargaSatuan").val('0');
                $("#disc").val('0');
                $("#jumlah").val('0');
                $("#stock").val('0');
            }
               
        });

    });

    document.addEventListener('keydown', function(event) {        
        if (event.key === 'F3') { // Menampilkan modal bantuan
            event.preventDefault();
            var selectField = document.getElementById('productName');
            selectField.focus();
        }   

        let postCreated = $("#createdBy").val(),
            postTrnNumber = $("#transNumber").val(),
            postPrdName = $("#prodNameHidden").val(),
            postQty = $("#qty").val(),
            postSatuan = $("#satuan").find(":selected").val(),
            postHarga = $("input[name=hargaSatuan]").val(),
            postDisc = $("input[name=disc]").val(),
            postJumlah = $("input[name=jumlah]").val(),
            postStock = $("input[name=stockHidden]").val();

        if (event.keyCode === 13 && postJumlah != "0") {
            event.preventDefault();
                
            if (postJumlah != '0' || postJumlah != '') {
                let postData = {created:postCreated, trnNumber:postTrnNumber, prdName:postPrdName, qty:postQty, satuan:postSatuan, harga:postHarga, disc:postDisc, jumlah:postJumlah, stock:postStock};
                sendData(postData);                
            }
        }  
    });

    function sendData(postData) {
        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");

        $.ajax({
            type : 'post',
            url : "{{route('Cashier')}}/productList/postProduct",
            data :  postData,
            success : function(data){             
                cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);  
                $("#prodName").val("").focus();           
                $("#qty").val("");            
                $("#hargaSatuan").val("");           
                $("#disc").val("");           
                $("#jumlah").val("");           
                $("#stockHidden").val("");           
                $("#stock").val("");       
            }
        });
    }
</script>