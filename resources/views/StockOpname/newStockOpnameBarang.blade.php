<?php
    $selisih = '';
    $test = 1095/100;
?>
<div class="row">
    <div class="col-12">
        <div class="card">            
            <div class="card-body table-responsive p-2">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-row-reverse">
                            <button class="btn btn-sm btn-default border-0 text-info font-weight-bold ml-2" data-toggle="collapse" href="#collapseDocOpname" role="button" aria-expanded="false" aria-controls="collapseDocOpname"><i class="fa-solid fa-file-pen"></i> Dok. Transaksi</button>
                            <button class="btn btn-sm btn-default border-0 text-danger font-weight-bold ml-2" id="cencelDocument" data-doc="{{$opnameNumber}}"><i class="fa-solid fa-xmark"></i> Batalkan Transaksi</button>
                            <button class="btn btn-sm btn-success border-0 font-weight-bold ml-2" id="saveDocument"><i class="fa-regular fa-floppy-disk"></i> Simpan Transaksi</button>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="collapse" id="collapseDocOpname">
                            <div class="card card-body">
                                <div id="displayDivDocument"></div>                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table  table-sm table-hover table-valign-middle text-nowrap" id="tableInputBarang">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th width="30%">Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Qty. Opname</th>
                                    <th>Lokasi</th>
                                    <th>Stok Sebelumnya</th>
                                    <th>Selisih</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-0">
                                        <input type="hidden" name="numberOpname" id="numberOpname" value="{{$opnameNumber}}">
                                        <input type="hidden" name="sumInputStock" id="sumInputStock" value="{{$sumStockOpname->inputStock}}">
                                    </td>
                                    <td class="p-0">
                                        <select class="form-control form-control-sm select2 rounded-0" name="product" id="product">
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
                                        <select name="lokasi" id="lokasi" class="form-control form-control-sm rounded-0">
                                            @foreach($lokasi as $l)
                                                <option value="{{$l->idm_site}}">{{$l->site_name}}</option>
                                            @endforeach
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
                                        <button type="button" class="btn btn-success  btn-sm elevation-1" id="submitItem"><i class="fa-solid fa-check"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="inputListOpname"></tbody>
                        </table>
                    </div>
                </div>
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
        $('#product').select2({
            width: 'resolve'
        });
        $("#product").focus();
        loadListData();
        let paramId = "{{$opnameNumber}}";
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/listInputBarang/editDocumentOpname/" + paramId,
            success : function(response){     
                $("#displayDivDocument").html(response).focus();
            }
        });        
    })
    
    $(document).ready(function(){
        let satuan =  document.getElementById('satuan'),
            lastStock =  document.getElementById('lastStock'),
            unitID =  document.getElementById('unitID'),
            productChange =  document.getElementById('product'),
            invID =  document.getElementById('invID'),
            unitVol =  document.getElementById('unitVol'),
            lokasi = document.getElementById('lokasi');
        
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
                location = $("#lokasi").val();
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
                    computeSaldo();
                })
            }
        });  
        lokasi.addEventListener("change", function(){
            $(".LOAD-SPINNER").fadeIn();
            let satuanVal = $("#satuan").val(),
                productVal = $("#product").val(),
                location = $(this).find(":selected").val();
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
                    computeSaldo();
                })
            }
        });      
        
        $("#qty").on('input', computeSaldo);
        function computeSaldo(){
            let lastStockVal = $("#lastStock").val(),
                qty = $("#qty").val();
            
            if (typeof qty == "undefined") {
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
        
        $('#cencelDocument').on('click', function (e) {
            e.preventDefault();
            var element = $(this);
            var  idparam = element.attr("data-doc");
            alertify.confirm("Apakah anda yakin ingin membatalkan transaksi ini ?",
            function(){
                alertify.success('Transaksi Dibatalkan');
                $.ajax({
                    type : 'get',
                    url : "{{route('stockOpname')}}/listInputBarang/cancelTrx/"+idparam,
                    success : function(data){
                        window.location.reload();
                    }
                });
            },
            function(){
                alertify.error('Cancel');
            }).set({title:"Transaksi Dibatalkan."});
        })

        $("#submitItem").on('click', function (e){
            e.preventDefault();
            addActivityItem();
        });


        $('#saveDocument').on('click', function (e) {
            e.preventDefault();
            let sumInputStock = $("#sumInputStock").val(),
                noOpname = $("#numberOpname").val();
            alertify.prompt("Masukkaan catatan bila ada [OPTIONAL]", "",
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
                }).set({title:"Simpan Transaksi"})
            ;
        });
    });
    
    function addActivityItem() {
        $("#tableInputBarang").fadeOut();
        let productInput = $("#product").val(),
            satuanInput = $("#satuan").val(),
            lastStockInput = $("#lastStock").val(),
            qtyInput = $("#qty").val(),
            totalInput = $("#total").val(),
            noOpname = $("#numberOpname").val(),
            invID = $("#invID").val(),
            unitID = $("#unitID").val(),
            unitVol = $("#unitVol").val(),
            location = $("#lokasi").val();
        let dataForm = {product:productInput,satuan:satuanInput,lastStock:lastStockInput,qty:qtyInput,total:totalInput,noOpname:noOpname,invID:invID,location:location,unitID:unitID,unitVol:unitVol};
        submitData(dataForm);
        $("#tableInputBarang").fadeIn();
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