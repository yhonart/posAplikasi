<div class="row">
    <div class="col-12">
        <div class="card card-info card-outline">
            <div class="card-body text-xs">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="d-flex flex-row-reverse">
                            <a href="#" class="btn btn-sm btn-default border-0 text-info font-weight-bold ml-2" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa-regular fa-file"></i> Dok. Transaksi
                            </a>
                            <a href="#" class="btn btn-sm btn-success border-0 font-weight-bold ml-2" id="submitButton">
                                <i class="fa-regular fa-floppy-disk"></i> Simpan Perubahan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="collapse" id="collapseExample">
                            <input type="hidden" name="sumLastStock" id="sumLastStock" value="{{$sumStockOpname->lastStock}}" readonly>
                            <input type="hidden" name="sumInputStock" id="sumInputStock" value="{{$sumStockOpname->inputStock}}" readonly>
                            <?php
                                $selisih = $sumStockOpname->inputStock - $sumStockOpname->lastStock;
                            ?>
                            <input type="hidden" name="selisih" id="selisih" value="{{$selisih}}">
                            <div id="editDocumentOpname"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-reponsive" style="height:700px">
                            <table class="table table-sm table-valign-middle" id="tableEditList">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="30%">Nama Barang</th>
                                        <th width="10%">Satuan</th>
                                        <th>Qty.</th>
                                        <th>Lokasi</th>
                                        <th>Stok Sebelumnya</th>
                                        <th>Selisih</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <form id="formTableInputData">
                                    <tr>
                                        <td>
                                            <input type="hidden" name="numberOpname" id="numberOpname" value="{{$idparam}}">
                                            <input type="hidden" class="form-control" name="invID" id="invID">
                                            <input type="hidden" class="form-control" name="unitID" id="unitID">
                                            <input type="hidden" class="form-control" name="unitVol" id="unitVol">
                                            <input type="hidden" class="form-control" name="location" id="location" value="{{$docOpname->loc_so}}">                                            
                                        </td>
                                        <td class="p-0">
                                            <select class="form-control" name="addProduct" id="addProduct">
                                                <option value="0">...</option>
                                                @foreach($mProduct as $mp)
                                                <option value="{{$mp->idm_data_product}}">{{$mp->product_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-0">
                                            <select class="form-control form-control-border form-control-sm" name="satuan" id="satuan">
                                                <option value="0">...</option>
                                            </select>
                                        </td>
                                        <td class="p-0">
                                            <input type="number" class="form-control form-control-border form-control-sm" name="qty" id="qty">
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control form-control-border form-control-sm" name="lastStock" id="lastStock" readonly>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" name="total" id="total" class="form-control form-control-border form-control-sm" readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                    </form>
                                </tbody>
                                <tbody id="listOpnamePrd"></tbody>                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $no = '1';
?>

<script>
    $(function(){
        $('#addProduct').select2({
          theme: 'bootstrap4'
        });
        $("#addProduct").focus();
        loadListData();
        let paramId = $("#numberOpname").val();
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/listInputBarang/editDocumentOpname/" + paramId,
            success : function(response){     
                $("#editDocumentOpname").html(response).focus();
            }
        });
        
    });
    
    $(document).ready(function(){
        let satuan =  document.getElementById('satuan'),
            lastStock =  document.getElementById('lastStock'),
            unitID =  document.getElementById('unitID'),
            productChange =  document.getElementById('addProduct'),
            invID =  document.getElementById('invID'),
            unitVol =  document.getElementById('unitVol');
            
        $("#addProduct").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('stockOpname')}}/listInputBarang/satuan/" + productID,
                success : function(response){     
                    $("#satuan").html(response).focus();
                }
            });
        });
        
        satuan.addEventListener("change", function(){
            let satuanVal = $(this).find(":selected").val(),
                productVal = $("#addProduct").val(),
                location = $("#location").val();
                
            if(satuanVal !== '0' || satuanVal !== undefined){
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
        $('#submitButton').on('click', function (e) {
            e.preventDefault();
            let sumLastStock = $("#sumLastStock").val(),
                sumInputStock = $("#sumInputStock").val(),
                noOpname = $("#numberOpname").val(),
                selisih = $("#selisih").val();
            let note = '';
            if(selisih < '0'){
                note = "Selisih kurang dari 0";
            }
            else{
                note = "Lebih atau sama dengan stock terakhir";
            }
            
            alertify.prompt("Masukkan Catatan Laporan [Optional]", note,
                function(evt, value ){
                    alertify.success('Ok: ' + value);
                    $.ajax({
                        type : 'post',
                        url : "{{route('stockOpname')}}/listInputBarang/submitOpnameReport",
                        data :  {sumLastStock:sumLastStock,sumInputStock:sumInputStock,selisih:selisih,note:note,noOpname:noOpname},
                        success : function(data){
                            window.location.reload();
                        }
                    });
                },
                function(){
                    alertify.error('Cancel');
                }).set({title:"Submit Laporan"})
            ;
            
        });
    });
    function addActivityItem() {
        let productInput = $("#addProduct").val(),
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
        // alert(productInput);
    }
    
    function submitData(dataForm){
        $.ajax({
            type : 'post',
            url : "{{route('stockOpname')}}/listInputBarang/submitOpname",
            data :  dataForm,
            success : function(data){
                if(data.success){
                    alertify.success(data.success);
                    $("form#formTableInputData")[0].reset();
                    loadTableData();
                }
                else if (data.warning){
                    alertify
                    .alert(data.warning, function(){
                        alertify.message('GAGAL! input Data');
                    }).set({title:"WARNING INFO"});
                }
                $("#addProduct").focus().select();
            }
        });
    }
    
    function loadTableData(){
        var  idparam = "{{$idparam}}";
        $.ajax({
            type:'get',
            url:"{{route('stockOpname')}}/listDataOpname/editOpname/"+idparam,
            dataType: 'html',
            success:function(response){
                // $("#listDocOpname").fadeOut("slow");
                $("#detailOpname").html(response);
            }
        });
    }
    
    function loadListData(){
        let noOpname = $("#numberOpname").val(),
            codeDisplay = '1';
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/listInputBarang/listBarang/"+noOpname+"/"+codeDisplay,
            success : function(response){
                $('#listOpnamePrd').html(response);
            }
        });
    }
</script>
