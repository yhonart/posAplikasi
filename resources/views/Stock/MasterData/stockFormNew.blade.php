<?php
    if ($nextID == 0) {
        $nextIdVal = '1';
    }
    else {
        $nextIdVal = $nextID + 1;
    }

    if (empty($nextIdSatuan)) {
        $nextIdUnit = '1';
    }
    else {
        $nextIdUnit = $nextIdSatuan->idm_product_satuan + 1;
    }
?>
<div class="row">
    <div class="col-12 p-0">
        <form id="FormNewProduct" autocomplete="off">
            
            <div class="form-group row">
                <label for="ProductName" class="form-label col-md-3">Nama Barang <sup class="font-weight-bold text-danger">*</sup></label>
                <div class="col-md-6">
                    <input type="text" name="ProductName" id="ProductName" style="text-transform: uppercase" class="form-control form-control-sm">                    
                </div>
            </div>
            
            <hr>
            <!--Pengaturan stock dan volume barang-->
            <p class="text-info font-weight-bold">Pengaturan Volume dan Satuan :</p>
            <table class="table table-sm table-borderless p-0 table-valign-middle">
                <thead>
                    <tr>
                        <th colspan="6" class="text-muted">* Disarankan input data dari ukuran Besar terlebih dahulu !</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form id="formNewUnit">
                            <input type="hidden" name="prdunID" value="{{$next_id}}">
                            <input type="hidden" name="stock" class="form-control form-control-sm " placeholder="Stock" value="0">
                            <td>
                                <select name="addPrdSize" id="addPrdSize" class="form-control form-control-sm ">
                                    <option value="0">Pilih Size</option>
                                    <option value="BESAR">BESAR</option>
                                    <option value="KECIL">KECIL</option>
                                    <option value="KONV">KONV</option>
                                </select>
                            </td>
                            <td>
                                <select name="addSatuan" id="addSatuan" class="form-control form-control-sm ">
                                    <option value="0">Pilih Satuan</option>
                                    @foreach($unit as $mU2)
                                        <option value="{{$mU2->unit_note}}">{{$mU2->unit_note}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="addVolumeBarang" id="addVolumeBarang" class="form-control form-control-sm " placeholder="Satuan Isi">
                            </td>
                            <td>
                                <input type="text" name="setBarcode" class="form-control form-control-sm " placeholder="Set Barcode">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm BTN-ADD-UNIT float-right " id="btnAddUnit">Tambah</button>
                            </td>
                        </form>
                    </tr>
                </tbody>
                <tbody id="displayTableVolume"></tbody>
            </table>
            <!--End Pengaturan stock dan volume barang-->
            
            <!--Pengaturan harga barang-->
            <p class="font-weight-bold"><span class="text-info">Pengaturan Harga Barang :</span></p>
            <a class="btn btn-default  border-0 font-weight-bold btn-sm mb-2 mt-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-plus"></i> Tambah Harga Barang 
            </a>
            <div class="collapse" id="collapseExample">            
                <table class="table table-sm table-borderless p-0 table-valign-middle">               
                    <tbody>
                        <tr>
                            <td>
                                <select name="unitHarga" id="unitHarga" class="form-control form-control-sm ">
                                    <option value="0">Pilih Ukuran</option>
                                    <option value="BESAR">BESAR</option>
                                    <option value="KECIL">KECIL</option>
                                    <option value="KONV">KONV</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control form-control-sm  PRICE" name="priceOrder" autocomplete="off" placeholder="Harga Pembelian">
                            </td>
                            <td>
                                <input class="form-control form-control-sm  PRICE" name="priceSell" autocomplete="off" placeholder="Harga Jual">
                            </td>
                            <td>
                                <select class="form-control form-control-sm " name="cosGroup" id="cosGroup">
                                        <option value="0" readonly>Tipe Pelangan</option>
                                    @foreach($listGroup as $cG)
                                        <option value="{{$cG->idm_cos_group}}">{{$cG->group_name}}</option>
                                    @endforeach
                                </select>
                            </td> 
                            <td><button type="button" class="btn btn-info btn-sm float-right " id="btnTambahHarga">Tambah</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="displayTableHrg"></div>
            <!--End pengaturan harga barang-->            
            <hr>
            <div class="form-group row">
                <label for="productImage" class="form-label col-md-3">Gambar Produk</label>
                <div class="col-md-6">
                    <input type="file" name="productImage" id="productImage" class="form-control-file">
                </div>
            </div>
            <div class="form-group row">
                <label for="pajak" class="form-label col-md-3">Pajak Jual</label>
                <div class="col-md-6">
                    <select name="pajak" id="pajak" class="form-control form-control-sm">
                        <option value="0" readonly></option>
                        <option value="PPN">PPN</option>
                        <option value="Non PPN">Non PPN</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-md-2">
                    <button type="button" id="productSubmit" class="btn btn-block btn-success font-weight-bold">Simpan</button>
                </div>
                <div class="col-md-2">
                    <button type="button" id="productCencel" class="btn btn-block btn-danger font-weight-bold">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12 red-alert p-2 rounded rounded-2 mb-2 notive-display" style="display:none;">
        <span class="font-weight-bold" id="notiveDisplay" ></span>
    </div>
</div>
<script>    
    $(function(){
        $('.select2').select2({
            theme: 'bootstrap4'
        }); 
        var id = $("#PrdNextID").val();
        $(".PRICE").mask('000.000.000',{
            reverse: true,
        });
        funcTableVol(id);
        funcTableHrg(id);
    });

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#btnAddUnit').on('click', function () {
            let size = $("#addPrdSize").find(":selected").val(),
                satuan = $("#addSatuan").find(":selected").val(),
                volume = $("input[name=addVolumeBarang]").val(),
                setBarcode = $("input[name=setBarcode]").val(),
                stock = $("input[name=stock]").val();
                id = $("input[name=PrdNextID]").val();
                
            $.ajax({
                url: "{{route('Stock')}}/ProductMaintenance/postAddUnit",
                type: 'POST',
                data: {prdID:id,size:size,satuan:satuan,volume:volume,setBarcode:setBarcode,stock:stock},
                success: function (data) {                    
                    funcTableVol(id);
                    funcTableHrg(id);
                    $("#addPrdSize").val('0');
                    $("#addSatuan").val('0');
                    $("#addVolumeBarang").val('');
                }
            });
        });

        $('#btnTambahHarga').on('click', function(){            
            let unitHarga = $('#unitHarga').find(":selected").val(),
                priceOrder = $("input[name=priceOrder]").val(),
                priceSell = $("input[name=priceSell]").val(),
                cosGroup = $('#cosGroup').find(":selected").val(),
                id = $("input[name=PrdNextID]").val();                
                $.ajax({
                    type : 'post',
                    url : "{{route('Stock')}}/AddProduct/PostProductSetGrouping",
                    data :  {unitHarga:unitHarga,priceOrder:priceOrder,priceSell:priceSell,cosGroup:cosGroup,routeID:id},
                    success : function(data){ 
                        if(data.warning){
                            alertify
                              .alert(data.warning, function(){
                                alertify.message('OK');
                              }).set({title:"Warning!"});
                        }else if(data.success){
                            alertify.success(data.success);
                            funcTableHrg(id);
                            $("#unitHarga").val('0');
                            $("#priceOrder").val('0');
                            $("#priceSell").val('0');
                            $("#cosGroup").val('0');
                        }
                    }
                });
            $('.load-input').val(''); 
        });
        
        $('#productCencel').on('click', function(){            
            let id = $("input[name=PrdNextID]").val();
                alertify
                  .alert("Apakah Anda Yakin Ingin Membatalkan Input Data ?", function(){
                    $.ajax({
                        type : 'get',
                        url : "{{route('Stock')}}/AddProduct/cencelSubmit/"+id,
                        success : function(data){        
                            window.location.reload();
                        }
                    });
                }).set({title:"Konfirmasi !"});
        });

        $('.price-text').mask('000.000.000', {reverse: true});
        let alertNotive = $('.notive-display');
       
        $('#productSubmit').on('click', function(e){ 
            var keyWord = '0';
            e.preventDefault();
            let data_form = new FormData(document.getElementById("FormNewProduct"));
            $.ajax({
                url : "{{route('Stock')}}/AddProduct/PostProduct",
                type: 'post',
                data: data_form,
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success : function (data) {
                    if (data.warning) {
                        $(".notive-display").fadeIn();
                        $("#notiveDisplay").html(data.warning);
                        alertNotive.removeClass('green-alert').addClass('red-alert');
                    }
                    else{
                        funcLoadForm();
                        funcLoadPrdList(keyWord);
                    }
                }
            })
        })
    });
    function funcTableVol(id){        
        $.ajax({
            type : 'get',
            url : "{{route('Stock')}}/AddProduct/sizeProductInput/"+id,
            success : function(response){
                $("#displayTableVolume").html(response);
            }
        });
    }
    function funcTableHrg(id){        
        $.ajax({
            type : 'get',
            url : "{{route('Stock')}}/AddProduct/prodCategoryInput/"+id,
            success : function(response){
                $("#displayTableHrg").html(response);
            }
        });
    }
    function funcLoadForm(){        
        $.ajax({
            type:'get',
            url:"{{route('Stock')}}/AddProduct", 
            success : function(response){
                $("#detailProduct").html(response);
            }           
        });
    }
    function funcLoadPrdList(keyWord){        
        $.ajax({
            type : 'get',
            url : "{{route('TransProduct')}}/StockBarang/cariTransaksiProduk/"+keyWord,
            success : function(response){
                $("#divListProduct").html(response);
            }
        });
    }
</script>