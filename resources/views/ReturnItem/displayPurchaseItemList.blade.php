<?php
$saldo = 0;
$no = '1';
?>
<div class="row mb-2">
    <div class="col-md-12">
        <button class="btn btn-info btn-sm " id="kembali"><i class="fa-solid fa-arrow-left"></i> Kembali</button>
        <button class="btn btn-success btn-sm " id="simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
        <button class="btn btn-danger btn-sm " id="refresh" style="display: none;"><i class="fa-solid fa-rotate"></i> Batal Simpan</button>
    </div>
</div>
<div class="row mb-2" id="keteranganRetur" style="display: none;">
    <div class="col-md-12">
        <label for="ketRetur">Item Text</label>
        <textarea name="ketRetur" id="ketRetur" class="form-control" rows="5" placeholder="Tambahkan keterangan lainnya apabila ada !"></textarea>
        <button class="btn btn-success btn-sm" id="simpanTransaksiRetur"><i class="fa-solid fa-circle-check"></i> Simpan</button>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body table-responsive p-0">
            <p class="text-muted pl-2 pt-2">* Gunakan "TAB" untuk pindah kolom</p>
            <table class="table table-sm table-valign-middle table-hover text-nowrap" id="listTableItem">
                <thead class="bg-gray-dark">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Qty. Beli</th>
                        <th>WH</th>
                        <th>Satuan</th>
                        <th>Retur</th>
                        <th>Harga Satuan</th>
                        <th>Point Retur</th>
                        <th>Stock Awal</th>
                        <th>Stock Akhir</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="idLo" id="idLo">
                            <input type="hidden" name="recive" id="recive">
                            <input type="hidden" name="unit" id="unit">
                            <input type="hidden" name="purchaseNumber" id="purchaseNumber" value="{{$numberpo}}">
                            <select class="form-control rounded-0 form-control-sm" name="selectProduct" id="selectProduct">
                                <option value="0" readonly></option>
                                @foreach($itemList as $tl)
                                <option value="{{$tl->idm_data_product}}">{{$tl->product_name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control rounded-0 form-control-sm " name="qtyPbl" id="qtyPbl" autocomplete="off" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control rounded-0 form-control-sm " name="wh" id="wh" autocomplete="off" readonly>
                        </td>
                        <td>
                            <select class="form-control rounded-0 form-control-sm " name="satuan" id="satuan">
                                <option value="0" readonly></option>
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control rounded-0 form-control-sm " name="qtyRetur" id="qtyRetur" autocomplete="off">
                        </td>
                        <td>
                                <input class="form-control form-control-sm rounded-0 text-right" name="hargaSatuan" id="hargaSatuan" autocomplete="off">
                        </td>
                        <td>
                            <input class="form-control form-control-sm rounded-0 text-right" name="point" id="point" readonly>
                        </td>
                        <td>
                            <input class="form-control form-control-sm rounded-0 text-right" name="stock" id="stock" readonly>
                        </td>
                        <td>
                            <input class="form-control form-control-sm rounded-0 text-right" name="saldo" id="saldo" readonly>
                        </td>
                        <td>
                            <input class="form-control form-control-sm rounded-0 text-right" name="keterangan" id="keterangan">
                        </td>
                        <td>
                            <button type="button" class="btn btn-default btn-sm " id="btnInsert"><i class="fa-solid fa-check"></i></button>
                        </td>
                    </tr>
                </tbody>
                <tbody id="listPengembalian"></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        tbodyItem();
    })

    $(document).ready(function(){
        $("#selectProduct").focus();
        let satuan = document.getElementById("satuan"),
            hargaSatuan = document.getElementById("hargaSatuan");
        
        let numberPO = "{{$numberpo}}";

        $("#simpan").on('click', function(e){
            $("#keteranganRetur").fadeIn();
            $("#simpan").fadeOut();
            $("#refresh").fadeIn();
        });

        $("#simpanTransaksiRetur").on('click', function(e){
            e.preventDefault();
            alertify.confirm("Apakah item yang anda masukkan sudah benar ?",
            function(){
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/submitRetur/"+numberPO,
                    success : function(response){
                        if (data.warning) {
                            alertify
                            .alert(data.warning, function(){
                                alertify.message('OK');
                            });
                        }else{
                            alertify.success(data.success);
                            backToReturHistory();
                        }
                    }
                });                
            },
            function(){
                alertify.error('Cancel');
            }).set({title:"Simpan Transaksi"});
        });        

        $("#selectProduct").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('returnItem')}}/productAction/" + productID,
                success : function(response){  
                    $("#satuan").html(response).focus();
                }
            });

            let satuanAsSelect = $("#satuan").val();
            // alert (productID+" "+numberPO);
            fetch("{{route('returnItem')}}/prodListAction/" + productID + "/" + numberPO)
            .then(response => response.json())
            .then(data => {                    
                if ((data.qtyPB || data.unitPB || data.dataId || data.qtyPB || data.warehouse || data.stock || data.unit)) {
                    hargaSatuan.value = accounting.formatMoney(data.price,{
                        symbol: "",
                        precision: 0,
                        thousand: ".",
                    });
                    let valPbl = data.qtyPB + " " + data.unitPB;
                    $("#qtyPbl").val(valPbl);
                    $("#idLo").val(data.dataId);
                    $("#recive").val(data.qtyPB);
                    $("#wh").val(data.warehouse);
                    $("#stock").val(data.stock);
                    $("#unit").val(data.unit);
                } else {
                    $("#qtyPbl").value = "0";
                    $("#idLo").value = "0";
                    $("#stock").value = "0";
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
        
        
        satuan.addEventListener("change", function() {
            let satuanUnit = $(this).find(":selected").val(),
                prdID = $("#selectProduct").val(),
                idLo = $("#idLo").val();
            
            // alert(satuanUnit+" "+prdID+" "+idLo);
                            
            // FATCH DATA SATUAN
            fetch("{{route('returnItem')}}/satuanAction/" + satuanUnit + "/" + prdID + "/" + idLo)
            .then(response => response.json())
            .then(data => {                    
                if ((data.price || data.stock || data.unit)) {
                    hargaSatuan.value = accounting.formatMoney(data.price,{
                        symbol: "",
                        precision: 0,
                        thousand: ".",
                    });
                    $("#qtyRetur").val("0").focus().select();
                    $("#stock").val(data.stock);
                    $("#unit").val(data.unit);
                } else {
                    hargaSatuan.value = "0";
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
        $("#qtyRetur").on('input', computeDisc);
        function computeDisc(){
            let valHrgSatuan = $("#hargaSatuan").val(),
                valQty = $("#qtyRetur").val(),
                valSock = $("#stock").val(),

                inputHrgSatuan = valHrgSatuan.replace(/\./g, ""),
                inputQty = valQty.replace(/\./g, "");

            if (typeof inputQty == "undefined" || typeof inputQty == "0") {
                return
            }
            
            let point = parseInt(inputHrgSatuan) * parseInt(inputQty),
                saldo = parseInt(valSock) - parseInt(inputQty);
            
            $("#point").val(accounting.formatMoney(point,{
                symbol: "",
                precision: 0,
                thousand: ".",
            })); 
            
            $("#saldo").val(saldo);
        }
        
        var activities = document.getElementById("qtyRetur");
        var activitiesHrgSatuan = document.getElementById("hargaSatuan");
        
        activities.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });

        activitiesHrgSatuan.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        
        function addActivityItem() {
            let product = $("#selectProduct").val(),
                satuan = $("#satuan").val(),
                qtyRetur = $("#qtyRetur").val(),
                hargaSatuan = $("#hargaSatuan").val(),
                point = $("#point").val(),
                id = $("#idLo").val(),
                purchaseNumber = $("#purchaseNumber").val(),
                recive = $("#recive").val(),
                stock = $("#stock").val(),
                saldo = $("#saldo").val(),
                qtyPbl = $("#qtyPbl").val(),
                unit = $("#unit").val(),
                keterangan = $("#keterangan").val();
            // alert(point);
                
            let dataform = {product:product, satuan:satuan, qtyRetur:qtyRetur, hargaSatuan:hargaSatuan, point:point, id:id, purchaseNumber:purchaseNumber,stock:stock,saldo:saldo,qtyPbl:qtyPbl,unit:unit,keterangan:keterangan};
            sendData(dataform);
        }
    
        function sendData(dataform) {
            $.ajax({
                type : 'post',
                url : "{{route('returnItem')}}/postItemReturn",
                data :  dataform,
                success : function(data){                  
                    getDataRetur();
                }
            });
        }
        
        $("#kembali").on('click', function(){
            $.ajax({
                type : 'get',
                url : "{{route('returnItem')}}/purchasingList",
                success : function(response){
                    $("#displayInfo").html(response);
                }
            });
        });
        
        $("#refresh").on('click', function(){
            getDataRetur();
        });
        
        function getDataRetur(){
            let purchaseNumber = "{{$numberpo}}";
            $.ajax({
                type : 'get',
                url : "{{route('returnItem')}}/purchasingList/displayItemList/"+purchaseNumber,
                success : function(response){
                    $("#displayInfo").html(response);
                }
            });
        }
        
    });
    
    function tbodyItem(){
        let purchCode = "{{$numberpo}}";
        $.ajax({
            type : 'get',
            url : "{{route('returnItem')}}/purchasingList/displayReturnItem/" + purchCode,
            success : function(response){  
                $("#listPengembalian").html(response);
            }
        }); 
    }

    function backToReturHistory(){
        let backToPage = "returnHistory";
        $.ajax({
            type : 'get',
            url : "{{route('returnItem')}}/"+backToPage,
            success : function(response){
                $("#displayInfo").html(response);
            }
        });
    }
</script>