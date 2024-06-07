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
        
        $("#prodNameHidden").val("").focus();
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
                }
            });
        }
        
        $('.price-text').mask('000.000.000', {reverse: true});
        loadTableData();
        let hargaSatuan = document.getElementById("hargaSatuan"),
            discount = document.getElementById("disc"),
            jumlah = document.getElementById("jumlah"),
            stock = document.getElementById("stock"),
            qty = document.getElementById('qty'),
            countBill = "{{$countBill}}";
            
        $("#prodNameHidden").change(function(){
            let productID = $(this).find(":selected").val();
            $("#satuan").load("{{route('Cashier')}}/productList/satuan/" + productID);
        })
        $("#satuan").change(function () {
            let satuanUnit = $(this).find(":selected").val(),
                prdID = $("#prodNameHidden").val();
                // alert(countBill);
            if (satuanUnit != "0") {                
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
        
                                $("#jumlah").val(accounting.formatMoney(priceVal * qtyVal,{
                                    symbol: "",
                                    precision: 0,
                                    thousand: ".",
                                }));
                                $("#disc").val("0").focus();
                            } else {
                                hargaSatuan.value = "0";
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                }
    
                // FATCH DATA STOCK
                if (satuanUnit !== undefined){
                    fetch("{{route('Cashier')}}/productList/stockBarang/" + satuanUnit + '/' + prdID)
                    .then(response => response.json())
                    .then(data => {                    
                        if (data.stock) {
                            let readyStock = data.stock,
                                qtyVal = $("#qty").val();
                            $("#stock").val(readyStock);
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
                    let beforeDisc = parseInt(inputHrgSatuan) * parseInt(inputQty);
                    $("#jumlah").val(accounting.formatMoney(beforeDisc-inputDisc,{
                        symbol: "",
                        precision: 0,
                        thousand: ".",
                    })); 
                }
            }
            else{
                $("#hargaSatuan").val('0');
                $("#disc").val('0');
                $("#jumlah").val('0');
                $("#stock").val('0');
            }
               
        });
        document.addEventListener('keydown', function(event) {  
            if (event.key === 'F3') {
                event.preventDefault();
                $("#prodNameHidden").val("").focus();
            }
        });
        
        var activities = document.getElementById("disc");
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
        $.ajax({
            type : 'post',
            url : "{{route('Cashier')}}/productList/postProduct",
            data :  dataform,
            
            success : function(data){                  
                loadTableData();
                cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                $('#prodNameHidden').val(null).trigger('change').focus();
                $("#qty").val(null);            
                $("#hargaSatuan").val(null);           
                $("#disc").val(null);           
                $("#jumlah").val(null);           
                $("#stockHidden").val(null);           
                $("#stock").val(null);           
                $("#satuan").val(null).trigger('change');       
                // $("#prodName").val("").focus();           
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