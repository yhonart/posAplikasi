<table class="table table-sm table-valign-middle table-head-fixed table-bordered text-xs table-hover">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th>Nama Barang [F3]</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Hrg. Satuan</th>
            <th>Disc</th>
            <th>Jumlah</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody id="trLoadProduct"></tbody>
    <tbody id="trInputProdut">
        <form id="formInputBarangKasir">
            <input type="hidden" name="createdBy" id="createdBy" value="{{Auth::user()->name}}">
            <input type="hidden" name="transNumber" id="transNumber" value="{{$billNumber}}">
            <tr>                            
                <td></td>
                <td>
                    <input type="hidden" class="form-control form-control-sm prd-input" name="prodName" id="prodName" autocomplete="off" list="browsers">
                    <input type="hidden" class="form-control form-control-sm prd-input" name="prodNameHidden1" id="prodNameHidden1">
                    <div id="livesearch"></div>
                    <select name="prodNameHidden" id="prodNameHidden" class="form-control form-control-sm select2">
                        <option value="0" readonly>F3 For Select</option>
                        @foreach($productList as $pL)
                            <option value="{{$pL->idm_data_product}}">{{$pL->product_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="qty" id="qty" class="form-control form-control-border border-width-3 quantity prd-input text-xs" autocomplete="off"></td>
                <td>
                    <select name="satuan" id="satuan" class="form-control form-control-border border-width-3 satuan prd-input text-xs">
                        <option value="0"></option>                        
                    </select>
                </td>
                <td><input type="text" name="hargaSatuan" id="hargaSatuan" class="form-control form-control-border border-width-3 price-text prd-input text-xs" readonly></td>
                <td><input type="text" name="disc" id="disc" class="form-control form-control-border price-text border-width-3 prd-input text-xs"></td>
                <td><input type="text" name="jumlah" id="jumlah" class="form-control form-control-border border-width-3 prd-input text-xs" readonly></td>
                <td>
                    <input type="hidden" name="stockHidden" id="stockHidden" class="form-control form-control-border text-xs" readonly>
                    <input type="text" name="stock" id="stock" class="form-control form-control-border prd-input border-width-3 text-xs" readonly>
                </td>
            </tr>
        </form>
    </tbody>
</table>
<script>
    
    $(function () {        
        $('.select2').select2({
            theme: 'bootstrap4',
            width: 'resolve' 
        });
    });   

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("#prodNameHidden").val(null).focus();
        // $("#prodName").keyup(function (e){
        //     e.preventDefault();            
        //     let keyWord = $("#prodName").val().trim();
        //     if (keyWord=='') {
        //         keyWord = '0';
        //     }
        //     searchProduct(keyWord);
        // });

        // function searchProduct(keyWord){   
        //     $.ajax({
        //         type : 'get',
        //         url : "{{route('Cashier')}}/productList/searchProduct/by/"+keyWord,
        //         success : function(response){
        //             $("#livesearch").html(response);
        //         }
        //     });
        // }
        
        $('.price-text').mask('000.000.000', {reverse: true});
        loadTableData();
        let hargaSatuan = document.getElementById("hargaSatuan"),
            discount = document.getElementById("disc"),
            jumlah = document.getElementById("jumlah"),
            stock = document.getElementById("stock"),
            qty = document.getElementById('qty'),
            satuan = document.getElementById('satuan'),
            countBill = "{{$countBill}}";
            
        $("#prodNameHidden").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/satuan/" + productID,
                success : function(response){     
                    $("#qty").val("1").focus();
                    $("#satuan").html(response);
                }
            });
        })
        satuan.addEventListener("change", function() {
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
                $("#qty").on('input', computeDisc);
                
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
                $('#prodNameHidden').val(null).focus();
                $("#qty").val(null);            
                $("#hargaSatuan").val(null);           
                $("#disc").val(null);           
                $("#jumlah").val(null);           
                $("#stockHidden").val(null);           
                $("#stock").val(null);           
                $("#satuan").val(null);       
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
</script>
<script>
    input.onfocus = function () {
  browsers.style.display = 'block';
  input.style.borderRadius = "5px 5px 0 0";  
};
for (let option of browsers.options) {
  option.onclick = function () {
    input.value = option.value;
    browsers.style.display = 'none';
    input.style.borderRadius = "5px";
  }
};

input.oninput = function() {
  currentFocus = -1;
  var text = input.value.toUpperCase();
  for (let option of browsers.options) {
    if(option.value.toUpperCase().indexOf(text) > -1){
      option.style.display = "block";
  }else{
    option.style.display = "none";
    }
  };
}
var currentFocus = -1;
input.onkeydown = function(e) {
  if(e.keyCode == 40){
    currentFocus++
   addActive(browsers.options);
  }
  else if(e.keyCode == 38){
    currentFocus--
   addActive(browsers.options);
  }
  else if(e.keyCode == 13){
    e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (browsers.options) browsers.options[currentFocus].click();
        }
  }
}

function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("active");
    }
  }
</script>