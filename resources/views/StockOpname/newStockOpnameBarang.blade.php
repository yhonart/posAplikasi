<?php
    $selisih = '';
    $test = 1095/100;
?>
<div class="row">
    <div class="col-12">
        <div class="card card-info card-outline">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Entry data barang</h3>
            </div>
            <div class="card-body table-responsive">
                <div class="row mb-2">
                    <div class="col-12">
                        <button class="btn btn-sm btn-primary rounded-0" id="displayDocument">Dokumen Opname</button>
                        <button class="btn btn-sm btn-success rounded-0" id="saveDocument">Simpan Transaksi</button>
                        <button class="btn btn-sm btn-danger rounded-0" id="cencelDocument">Batalkan Transaksi</button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <div id="displayDivDocument"></div>
                    </div>
                </div>
                <table class="table table-valign-middle table-hover table-sm">
                    <thead class="bg-indigo border border-info">
                        <tr>
                            <th></th>
                            <th width="30%">Nama Barang</th>
                            <th>Satuan</th>
                            <th>Qty. Opname</th>
                            <th>Stok Sebelumnya</th>
                            <th>Selisih</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 border">
                                <input type="hidden" name="numberOpname" id="numberOpname" value="{{$opnameNumber}}">
                                <input type="hidden" name="sumInputStock" id="sumInputStock" value="{{$sumStockOpname->inputStock}}">
                            </td>
                            <td class="p-0">
                                <select class="form-control form-control-sm select2" name="product" id="product">
                                    <option value="0" readonly>-- Pilih Item --</option>
                                    @foreach($mProduct as $mp)
                                        <option value="{{$mp->idm_data_product}}">{{$mp->product_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select class="form-control form-control-sm rounded-0" name="satuan" id="satuan">
                                    <option value="0" readonly>-- Satuan --</option>
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="text" name="qty" id="qty" class="form-control form-control-sm rounded-0">
                            </td>
                            <td class="p-0">
                                <input type="text" name="lastStock" id="lastStock" class="form-control form-control-sm rounded-0" readonly>
                            </td>
                            <td>
                                <input type="text" name="total" id="total" class="form-control form-control-sm rounded-0" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-flat btn-sm elevation-1" id="submitItem"><i class="fa-solid fa-check"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="inputListOpname"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <input type="hidden" name="unitID" id="unitID">
        <input type="hidden" name="invID" id="invID">
        <input type="hidden" name="unitVol" id="unitVol">
        <input type="hidden" name="location" id="location" value="{{$stockOpname->loc_so}}">
    </div>
</div>

<script>
    $(function(){
        $('#product').select2();
        $("#product").focus();
        loadListData();
        let paramId = "{{$opnameNumber}}";
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/listInputBarang/editDocumentOpname/" + paramId,
            success : function(response){     
                $("#editDocumentOpname").html(response).focus();
            }
        });
    })
    
    $(document).ready(function(){
        let satuan =  document.getElementById('satuan'),
            lastStock =  document.getElementById('lastStock'),
            unitID =  document.getElementById('unitID'),
            productChange =  document.getElementById('product'),
            invID =  document.getElementById('invID'),
            unitVol =  document.getElementById('unitVol');
        
        $("#product").change(function(){
            $(".LOAD-SPINNER").fadeIn();
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('stockOpname')}}/listInputBarang/satuan/" + productID,
                success : function(response){     
                    $(".LOAD-SPINNER").fadeOut();
                    $("#satuan").html(response).focus();
                }
            });
        })
        
        satuan.addEventListener("change", function(){
            $(".LOAD-SPINNER").fadeIn();
            let satuanVal = $(this).find(":selected").val(),
                productVal = $("#product").val(),
                location = $("#location").val();
            // alert (location); 
            if(satuanVal !== '0' || satuanVal !== undefined){
                $(".LOAD-SPINNER").fadeOut();
                fetch("{{route('stockOpname')}}/listInputBarang/lastQty/"+satuanVal+"/"+productVal+"/"+location)
                .then(response => response.json())
                .then(data => {
                    lastStock.value = data.lastQty;
                    invID.value = data.invID;
                    unitID.value = data.unitID;
                    unitVol.value = data.unitVol;
                    $("#qty").val(0).focus().select();
                })
            }
        });
        
        $("#qty").on('input', computeSaldo);
        function computeSaldo(){
            let lastStockVal = $("#lastStock").val(),
                qty = $("#qty").val();
            
            if (typeof qty == "undefined" || typeof qty == "0") {
                return
            }
            $("#total").val(parseFloat(qty) - parseFloat(lastStockVal));
        }
        
        var actQty = document.getElementById("qty");
        
        actQty.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        
        $("#submitItem").on('click', function (e){
            e.preventDefault();
            addActivityItem();
        })
        
        $('#saveDocument').on('click', function (e) {
            e.preventDefault();
            let sumInputStock = $("#sumInputStock").val(),
                noOpname = $("#numberOpname").val();
                
            if(sumInputStock === '0' || sumInputStock === ''){
                alertify
                .alert("Tidak ada data barang yang dimasukkan, mohon periksa kembali.", function(){
                    alertify.message('OK');
                }).set({title:"ALERT !"});
            }
            else{
                alertify.prompt("Masukkaan catatan bila perlu [OPTIONAL]", "",
                    function(evt, value ){
                        alertify.success('Ok: ' + value);
                        $.ajax({
                            type : 'post',
                            url : "{{route('stockOpname')}}/listInputBarang/submitOpnameReport",
                            data :  {sumInputStock:sumInputStock,note:value,noOpname:noOpname},
                            success : function(data){
                                window.location.reload();
                            }
                        });
                    },
                    function(){
                        alertify.error('Cancel');
                    }).set({title:"Submit Laporan"})
                ;
            }
        });
        
        $('#displayDocument').on('click', function (e){
            e.preventDefault();
            let docNumber = $("#numberOpname").val();
            $.ajax({
                type : 'get',
                url : "{{route('stockOpname')}}/listInputBarang/editDocumentOpname/"+docNumber,
                success : function(response){
                    $("#displayDivDocument").html(response);
                }
            });
        })
    });
    
    function addActivityItem() {
        let productInput = $("#product").val(),
            satuanInput = $("#satuan").val(),
            lastStockInput = $("#lastStock").val(),
            qtyInput = $("#qty").val(),
            totalInput = $("#total").val(),
            noOpname = $("#numberOpname").val(),
            invID = $("#invID").val(),
            unitID = $("#unitID").val(),
            unitVol = $("#unitVol").val(),
            location = $("#location").val();
        let dataForm = {product:productInput,satuan:satuanInput,lastStock:lastStockInput,qty:qtyInput,total:totalInput,noOpname:noOpname,invID:invID,location:location,unitID:unitID,unitVol:unitVol};
        submitData(dataForm);
    }
    
    function submitData(dataForm){
        $(".LOAD-SPINNER").fadeIn();
        var loadDiv = "listInputBarang";
        $.ajax({
            type : 'post',
            url : "{{route('stockOpname')}}/listInputBarang/submitOpname",
            data :  dataForm,
            success : function(data){
                $(".LOAD-SPINNER").fadeOut();
                if(data.success){
                    alertify.success(data.success);
                    loadDisplay(loadDiv);
                }
                else if (data.warning){
                    alertify
                    .alert(data.warning, function(){
                        alertify.message('GAGAL! input Data');
                    }).set({title:"WARNING INFO"});
                }
                $("#product").focus().select();
            }
        });
    }
    
    function loadDisplay(loadDiv){
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/"+loadDiv,
            success : function(response){
                $('#displayOpname').html(response);
            }
        });
    }
    
    function loadListData(){
        let noOpname = $("#numberOpname").val(),
            codeDisplay = '2';
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/listInputBarang/listBarang/"+noOpname+"/"+codeDisplay,
            success : function(response){
                $('#inputListOpname').html(response);
            }
        });
    }
    
</script>