<div class="row">
    <div class="col-12">
        <table class="table table-sm table-striped table-hover">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Nama Barang</th>
                    <th width="10%">Satuan</th>
                    <th width="15%">Qty</th>
                    <th>Harga Satuan</th>
                    <th>Dis Rp.</th>
                    <th>Jumlah</th>
                    <th>Gudang</th>
                </tr>
            </thead>
            <tbody id="tableListBarang"></tbody>
            <tbody>
                <td>
                    <input type="hidden" name="inputNoPo" id="inputNoPo" value="{{$dataEdit}}">
                </td>
                <td>
                    <select name="selectProduct" id="selectProduct" class="form-control form-control-sm select2">
                        <option value="0"></option>
                        @foreach($prodName as $pN)
                            <option value="{{$pN->idm_data_product}}">{{$pN->product_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="satuan" id="satuan" class="form-control form-control-sm">
                        <option value="0"></option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" name="inputQty" id="inputQty">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="inputHrgSatuan" id="inputHrgSatuan">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="inputDiscount" id="inputDiscount">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="inputJumlah" id="inputJumlah">
                </td>
                <td>
                    <select name="selectSatuan" id="selectGudang" class="form-control form-control-sm">
                        <option value="0"></option>
                        @foreach($warehouse as $wh)
                            <option value="{{$wh->idm_site}}">{{$wh->site_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tbody>
            <tbody id="tableSum">
                
            </tbody>
        </table>
    </div>
</div>
<script>

    $(function() {
        $(".select2").select2({
            width: 'resolve'
        });
        loadTableData();
        loadSumData();
    });
    
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("#selectProduct").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/satuan/" + productID,
                success : function(response){     
                    $("#satuan").html(response).focus();
                    $("#inputQty").val("1");
                }
            });
        });
        
        let hargaSatuan = document.getElementById("inputHrgSatuan"),
            discount = document.getElementById("inputDiscount"),
            satuan = document.getElementById("satuan");
            
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
                                $("#inputDiscount").val("0").focus().select();
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
        
        $("#inputQty").on('input', computeDisc);
        $("#inputDiscount").on('input', computeDisc);
                
        function computeDisc(){
            let valHrgSatuan = $("#inputHrgSatuan").val(),
                valQty = $("#inputQty").val(),
                valDisc = $("#inputDiscount").val(), 

                inputHrgSatuan = valHrgSatuan.replace(/\./g, ""),
                inputQty = valQty.replace(/\./g, "");
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
        
        $("#selectGudang").change(function(){
            let warehouse = $(this).find(":selected").val(),
                poVal = $("#inputNoPo").val(),
                prdVal = $("#selectProduct").val(),
                satuanVal = $("#satuan").val(),
                qtyVal = $("#inputQty").val(),
                unitPrice = $("#inputHrgSatuan").val(),
                disVal = $("#inputDiscount").val(),
                jumlahVal = $("#inputJumlah").val();
                
            let routeIndex = "{{route('Purchasing')}}",
                dataIndex = "addPurchasing",
                panelProductList = $("#divPageProduct");
            
            $.ajax({
                type : 'post',
                url : "{{route('Purchasing')}}/tableInputBarang/postBarang",
                data :  {warehouse:warehouse, poVal:poVal, prdVal:prdVal, satuanVal:satuanVal,qtyVal:qtyVal,unitPrice:unitPrice,disVal:disVal,jumlahVal:jumlahVal},
                success : function(data){                
                    loadTableData();
                    loadData(dataIndex);
                    // $('#selectProduct').val(null).focus();
                    // $("#inputNoPo").val(null);            
                    // $("#satuan").val(null);           
                    // $("#inputQty").val(null);           
                    // $("#inputHrgSatuan").val(null);           
                    // $("#inputDiscount").val(null);           
                    // $("#inputJumlah").val(null); 
                    // $("#selectGudang").val(null); 
                }
            }); 
        });
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