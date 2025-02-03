<hr>
<div class="row mb-1">
    <div class="col-12">
        <div id="tableSum"></div>
    </div>
</div>  
<div class="row">
    <div class="col-12">
        <div class="card card-body p-0 table-responsive">
            <p id="notifLoading" class="bg-danger p-2" style="display:none;">Proses Load Data</p>
            <input type="hidden" name="inputNoPo" id="inputNoPo" value="{{$statusPurchase->purchase_number}}">
            <table class="table table-sm table-hover table-valign-middle animate__animated animate__fadeIn" id="tableInputBarang">
                <thead class="bg-indigo">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Barang</th>
                        <th width="10%">Satuan</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Dis Rp.</th>
                        <th>Jumlah</th>
                        <th>Gudang</th>
                        <th>Stok Awal</th>
                        <th>Stok Akhir</th>
                        <th>#</th>
                    </tr>
                </thead>
                @if(empty($statusPurchase) OR $statusPurchase->status <> '3')
                <tbody>
                    <td class="p-0">
                    </td>
                    <td class="p-0">
                        <select name="selectProduct" id="selectProduct" class="form-control form-control-sm">
                            <option value="0">---</option>
                            @foreach($prodName as $pN)
                                <option value="{{$pN->idm_data_product}}">{{$pN->product_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="p-0">
                        <select name="satuan" id="satuan" class="form-control form-control-sm ">
                            <option value="0">---</option>
                        </select>
                    </td>
                    
                    <td class="p-0">
                        <input type="number" class="form-control form-control-sm " name="inputQty" id="inputQty" placeholder="Qty" autocomplete="off">
                    </td>
                    <td class="p-0">
                        <input type="text" class="form-control form-control-sm " name="inputHrgSatuan" id="inputHrgSatuan" placeholder="Harga Satuan"autocomplete="off">
                    </td>
                    <td class="p-0">
                        <input type="text" class="form-control form-control-sm " name="inputDiscount" id="inputDiscount" placeholder="Discount" autocomplete="off">
                    </td>
                    <td class="p-0">
                        <input type="text" class="form-control form-control-sm " name="inputJumlah" id="inputJumlah" placeholder="Jumlah" autocomplete="off" readonly>
                    </td>
                    <td class="p-0">
                        <select name="selectGudang" id="selectGudang" class="form-control form-control-sm ">
                            <option value="0">---</option>
                            @foreach($warehouse as $wh)
                                <option value="{{$wh->idm_site}}">{{$wh->site_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="p-0">
                        <input type="number" class="form-control form-control-sm " name="stockAwal" id="stockAwal" readonly>
                    </td>
                    <td class="p-0">
                        <input type="number" class="form-control form-control-sm " name="stockAkhir" id="stockAkhir" placeholder="Stok Akhir" readonly>
                    </td>
                    <td class="p-0">
                        <button class="btn border-0 elevation-0 btn-default " id="btnSubmit"><i class="fa-solid fa-check"></i></button>
                    </td>
                </tbody>
                @endif
                <tbody id="tableListBarang"></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#selectProduct").select2({
            width: 'resolve'
        });
        loadTableData();
        loadSumData();
        $("#selectProduct").focus();
    });
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        let hargaSatuan = document.getElementById("inputHrgSatuan"),
            discount = document.getElementById("inputDiscount"),
            satuan = document.getElementById("satuan"),
            stockAwal = document.getElementById("stockAwal");
            
        $("#selectProduct").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/satuan/" + productID,
                success : function(response){     
                    $("#satuan").html(response).focus();
                }
            });
            fetch("{{route('Purchasing')}}/getAutoPrice/" + productID)
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
                        let qtyVal = '1',
                            priceVal = data.price,
                            discVal = data.discount;
                        $("#inputJumlah").val(accounting.formatMoney(priceVal * qtyVal,{
                            symbol: "",
                            precision: 0,
                            thousand: ".",
                        }));
                    } else {
                        hargaSatuan.value = "0";
                    }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
            
        satuan.addEventListener("change", function() {
            let satuanUnit = $(this).find(":selected").val(),
                prdID = $("#selectProduct").val();
            
            if (satuanUnit !== "0") {
                if (satuanUnit !== undefined){
                    fetch("{{route('Purchasing')}}/tableInputBarang/hargaSatuan/" + satuanUnit + "/" + prdID)
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
                                let qtyVal = $("#inputQty").val(),
                                    priceVal = data.price,
                                    discVal = data.discount;
        
                                $("#inputJumlah").val(accounting.formatMoney(priceVal * qtyVal,{
                                    symbol: "",
                                    precision: 0,
                                    thousand: ".",
                                }));
                                $("#inputQty").val(1).focus().select();
                                computeDisc();
                            } else {
                                hargaSatuan.value = "0";
                            }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            }
        });
        
        
        var gudang = document.getElementById('selectGudang');
        
        gudang.addEventListener("change", function(){
            let gudangVal = $(this).find(":selected").val(),
                satuanVal = $("#satuan").val(),
                productVal = $("#selectProduct").val(),
                qty = $("#inputQty").val();
                
                if(satuanVal !== '0' || productVal !== '0'){
                    fetch("{{route('Purchasing')}}/tableInputBarang/stockIden/" + gudangVal + "/" + satuanVal + "/" + productVal)
                    .then(response => response.json())
                    .then(data => {
                        if (data.stock){
                            stockAwal.value = data.stock;
                        }
                        else{
                            stockAwal.value = '0';
                        }
                        $("#stockAkhir").val(parseInt(data.stock) + parseInt(qty));
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
                
                let valStockAwal = $("#stockAwal").val();
                $("#btnSubmit").focus().removeClass('btn-default');
                $("#btnSubmit").focus().addClass('bg-success');
        })
        
        var activeQty = document.getElementById("inputQty");
        var activeHrg = document.getElementById("inputHrgSatuan");
        var activeDisc = document.getElementById("inputDiscount");
        var activeStockAkhir = document.getElementById("btnSubmit");
        
        $("#btnSubmit").on('click', function(e){
            e.preventDefault();
            submitData();
        });
        
        activeQty.addEventListener('keydown', function(event){
            if (event.keyCode === 13) {
                event.preventDefault();
                computeDisc();
                $("#inputHrgSatuan").focus().select();
            }    
        });
        
        activeHrg.addEventListener('keydown', function(event){
            if (event.keyCode === 13) {
                event.preventDefault();
                computeDisc();
                $("#inputDiscount").focus().select();
            }    
        });
        
        activeDisc.addEventListener('keydown', function(event){
            if (event.keyCode === 13) {
                event.preventDefault();
                computeDisc();
                $("#inputJumlah").focus().select();
            }    
        });
        
        activeStockAkhir.addEventListener('keydown', function(event){
            if (event.keyCode === 13) {
                event.preventDefault();
                submitData();
            }    
        });
        
        $("#inputQty").on('input', computeDisc);
        // $("#inputDiscount").on('input', computeDisc);
                
        function computeDisc(){
            let valHrgSatuan = $("#inputHrgSatuan").val(),
                valQty = $("#inputQty").val(),
                valDisc = $("#inputDiscount").val(),
                stockAwalVal = $("#stockAwal").val();

            let inputHrgSatuan = valHrgSatuan.replace(/\./g, ""),
                inputQty = valQty.replace(/\./g, ""),
                inputDisc = valDisc.replace(/\./g, "");
            
            if (typeof inputDisc == "undefined" || typeof inputDisc == "0") {
                return
            }
            let beforeDisc = parseInt(inputHrgSatuan) * parseInt(inputQty);
            $("#inputJumlah").val(accounting.formatMoney(beforeDisc-inputDisc,{
                symbol: "",
                precision: 0,
                thousand: ".",
            })); 
        }
        
        function submitData() {
            $(".LOAD-SPINNER").fadeIn();
            let warehouse = $("#selectGudang").val(),
                poVal = $("#inputNoPo").val(),
                prdVal = $("#selectProduct").val(),
                satuanVal = $("#satuan").val(),
                qtyVal = $("#inputQty").val(),
                unitPrice = $("#inputHrgSatuan").val(),
                disVal = $("#inputDiscount").val(),
                jumlahVal = $("#inputJumlah").val(),
                stockAwal = $("#stockAwal").val(),
                stockAkhir = $("#stockAkhir").val();
                
            let routeIndex = "{{route('Purchasing')}}",
                dataIndex = "addPurchasing",
                panelProductList = $("#divPageProduct");
            
            $.ajax({
                type : 'post',
                url : "{{route('Purchasing')}}/tableInputBarang/postBarang",
                data :  {warehouse:warehouse, poVal:poVal, prdVal:prdVal, satuanVal:satuanVal,qtyVal:qtyVal,unitPrice:unitPrice,disVal:disVal,jumlahVal:jumlahVal,stockA:stockAwal,stockB:stockAkhir},
                success : function(data){   
                    $(".LOAD-SPINNER").fadeOut();
                    loadData(dataIndex);
                }
            }); 
        }
    });
    
    function loadTableData(){
        let numberPO = $("#inputNoPo").val();
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/tableInputBarang/loadBarang/"+numberPO,
            success : function(response){                
                $("#tableListBarang").html(response);
            }
        });
    }
    
    function loadSumData(){
        let numberPO = $("#inputNoPo").val();
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/tableInputBarang/tableSum/"+numberPO,
            success : function(response){                
                $("#tableSum").html(response);
            }
        });
    }
    
    function loadData(dataIndex){
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/"+dataIndex,
            success : function(response){
                $("#divPageProduct").html(response);
            }
        });
    }
</script>