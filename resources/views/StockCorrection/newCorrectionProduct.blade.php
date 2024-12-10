<?php
    $selisih = '';
?>
<div class="card card-body p-2 table-responsive">
    <div class="row mb-2">
        <div class="col-md-12">
            <form id="formSubmitReportKoreksi">
                <div class="form-group">
                    <input type="hidden" class="form-control form-control-sm" name="sumQty" id="sumQty" value="{{$sumKoreksi->qty}}" readonly>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control form-control-sm" name="sumStock" id="sumStock" value="{{$sumKoreksi->stock}}" readonly>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control form-control-sm" name="t_item" id="t_item" value="{{$sumKoreksi->countKrs}}" readonly>
                </div>
                <div class="form-group">
                    <button class="btn btn-outline-info border-0 font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-file-pen"></i> Dokumen Koreksi
                    </button>
                    <button type="submit" class="btn btn-outline-success border-0 font-weight-bold" id="submitButton"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                </div>
            </form>
            <div class="collapse" id="collapseExample">
                <form class="form" id="formEditKoreksi">
                    <div class="form-group row">
                        <label class="label col-6 col-md-2">No. Koreksi</label>
                        <div class="col-6 col-md-4">
                            <input type="text" name="nomorKoreksi" id="nomorKoreksi" class="form-control form-control-sm" value="{{$koreksi->number}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-6 col-md-2">Tanggal</label>
                        <div class="col-6 col-md-4">
                            <input type="text" name="filterTanggal" id="filterTanggal" class="form-control form-control-sm" value="{{$koreksi->dateInput}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-6 col-md-2">Keterangan</label>
                        <div class="col-6 col-md-4">
                            <textarea class="form-control" rows="4" placeholder="Enter ..." name="description" id="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success font-weight-bold btn-block"><i class="fa-solid fa-magnifying-glass"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-sm table-hover table-valign-middle text-nowrap">
                <thead class="bg-gray">
                    <tr>
                        <th>No</th>
                        <th width="30%">Nama Barang</th>
                        <th>Kode Lokasi</th>
                        <th>Satuan</th>
                        <th>D/K</th>
                        <th>Qty</th>
                        <th>Stok Awal</th>
                        <th>Perbaikan</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    <form id="formKoreksiInputBarang">
                        <tr>
                            <td>
                                #
                                <input type="hidden" name="numberKoreksi" id="numberKoreksi" value="{{$numberKrs}}">
                                <input type="hidden" class="form-control form-control-sm" name="invID" id="invID">
                            </td>
                            <td class="p-0">
                                <select class="form-control val-reset" name="product" id="product">
                                    <option value="0">..</option>
                                    @foreach($mProduct as $mP)
                                        <option value="{{$mP->idm_data_product}}">{{$mP->product_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select class="form-control form-control-sm val-reset " name="location" id="location">
                                    <option value="0">..</option>
                                    @foreach($mSite as $site)
                                        <option value="{{$site->idm_site}}">{{$site->site_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select class="form-control form-control-sm val-reset " name="satuan" id="satuan">
                                    <option value="0"></option>
                                </select>
                            </td>
                            <td class="p-0">
                                <select class="form-control form-control-sm val-reset " name="t_type" id="t_type">
                                    <option value="D">Debit</option>
                                    <option value="K">Kredit</option>
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control form-control-sm val-reset " name="qty" id="qty" autocomplate="off">
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control form-control-sm val-reset " name="lastStock" id="lastStock" readonly>
                            </td>
                            <td class="p-0">
                                <input type="text" class="form-control form-control-sm val-reset " name="tPerbaikan" id="tPerbaikan" readonly>
                            </td>
                            <td>
                                <button class="btn btn-default  btn-sm elevation-1" id="addItemKorek"><i class="fa-solid fa-check"></i></button>
                            </td>
                        </tr>
                    </form>
                </tbody>
                <tbody id="locadListKoreksi"></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#product').select2({
            width: 'resolve'
        });
        $("#product").focus();
        loadListData();
    })
    
    $(document).ready(function(){
        let satuan =  document.getElementById('satuan'),
            lastStock =  document.getElementById('lastStock'),
            invID =  document.getElementById('invID'),
            location = document.getElementById('location');
        
        $("#product").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('stockOpname')}}/listInputBarang/satuan/" + productID,
                success : function(response){ 
                    $("#location").focus();
                    $("#satuan").html(response);
                }
            });
        })
        
        satuan.addEventListener("change", function(){
            let satuanVal = $(this).find(":selected").val(),
                locationVal = $("#location").find(":selected").val(),
                productVal = $("#product").val();
            // alert(productVal);
            if(satuanVal !== '0' || satuanVal !== undefined){
                fetch("{{route('koreksiBarang')}}/listInputBarang/lastQty/"+satuanVal+"/"+productVal+"/"+locationVal)
                .then(response => response.json())
                .then(data => {
                    lastStock.value = data.lastQty;
                    invID.value = data.invID;
                    $("#t_type").focus();
                })
            }
        });
        
        $("#t_type").change(function(){
            $("#qty").val("0").select();
        });
        
        $("#location").change(function(){
            $("#satuan").focus().select();
        });
        
        $("#qty").on('input', computeSaldo);
        
        function computeSaldo(){
            let lastStockVal = $("#lastStock").val(),
                qty = $("#qty").val(),
                t_type = $("#t_type").find(":selected").val();
                
            if (typeof qty == "undefined" || typeof qty == "0") {
                return
            }
            
            if (t_type === 'D'){
                $("#tPerbaikan").val(parseFloat(qty) + parseFloat(lastStockVal));
            }
            else if (t_type === 'K'){                
                $("#tPerbaikan").val(parseFloat(lastStockVal) - parseFloat(qty));
            }

            $("#addItemKorek").removeClass('btn-default');
            $("#addItemKorek").addClass('bg-success');
        }
        
        var actQty = document.getElementById("qty");
        
        actQty.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        
        $("#addItemKorek").on('click', function (event){
            event.preventDefault();
            addActivityItem();
        })
        
        $('#submitButton').on('click', function (e) {
            $("#displayNotif").fadeIn("slow");
            e.preventDefault();
            let sumQty = $("#sumQty").val(),
                sumStock = $("#sumStock").val(),
                number = $("#numberKoreksi").val();
                t_item = $("#t_item").val();
            if(t_item === '0'){
                alertify
                  .alert("Tidak ada data yang di masukkan!", function(){
                    alertify.message('OK');
                  });
            }
            else{
                alertify.prompt("Masukkan Catatan Laporan (Optional)", "...",
                    function(evt, value ){
                        alertify.success('Ok: ' + value);
                        $.ajax({
                            type : 'post',
                            url : "{{route('koreksiBarang')}}/listInputBarang/submitLapKoreksi",
                            data :  {sumQty:sumQty,sumStock:sumStock,number:number,t_item:t_item},
                            success : function(data){
                                window.location.reload();
                            }
                        }).set({title:"Submit Laporan"});
                    },
                    function(){
                        alertify.error('Cancel');
                    })
                ;
            }
            $("#displayNotif").fadeOut("slow");
        });
    });
    
    function addActivityItem() {
        let productInput = $("#product").val(),
            location = $("#location").val(),
            satuan = $("#satuan").val(),
            t_type = $("#t_type").val(),
            qty = $("#qty").val(),
            lastStock = $("#lastStock").val(),
            invID = $("#invID").val(),
            numberKoreksi = $("#numberKoreksi").val(),
            tPerbaikan = $("#tPerbaikan").val();            
            
        let dataForm = {product:productInput,location:location,satuan:satuan,t_type:t_type,qty:qty,lastStock:lastStock,invID:invID,numberKoreksi:numberKoreksi,tPerbaikan:tPerbaikan};
        submitData(dataForm);
    }
    
    function submitData(dataForm){
        let display = "listInputBarang";
        $("#displayNotif").fadeIn("slow");
        $.ajax({
            type : 'post',
            url : "{{route('koreksiBarang')}}/listInputBarang/submitKoreksi",
            data :  dataForm,
            success : function(data){
                // loadListData();
                if(data.success){
                    viewTableInput(display);
                    $("form#formKoreksiInputBarang")[0].reset();
                    alertify.success(data.success);
                }
                else if (data.warning){
                    alertify
                    .alert(data.warning, function(){
                        alertify.message('OK');
                    });
                }
                $("#displayNotif").fadeOut("slow");
            }
        });
    }
    function viewTableInput(display) {
        $.ajax({
            type : 'get',
            url : "{{route('koreksiBarang')}}/"+display,
            success : function(response){
                $('#displayOnDiv').html(response);
            }
        });
    } 
    
    function loadListData(){
        let number = $("#numberKoreksi").val();
        $.ajax({
            type : 'get',
            url : "{{route('koreksiBarang')}}/listInputBarang/listBarang/"+number,
            success : function(response){
                $('#locadListKoreksi').html(response);
            }
        });
    }
    
</script>