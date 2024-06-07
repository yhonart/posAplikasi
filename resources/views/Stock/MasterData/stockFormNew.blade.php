<?php
    if (empty($nextID)) {
        $nextIdVal = '1';
    }
    else {
        $nextIdVal = $nextID->idm_data_product + 1;
    }

    if (empty($nextIdSatuan)) {
        $nextIdUnit = '1';
    }
    else {
        $nextIdUnit = $nextIdSatuan->idm_product_satuan + 1;
    }
?>
<div class="row">
    <div class="col-12">
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-info"></i> Alert!</h5>
            Form ini hanya untuk input data barang / produk yang tidak ada pada stock.
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form id="FormNewProduct" autocomplete="off">
            <input type="hidden" name="nextID" id="nextID" value="{{$nextIdVal}}"> 
            <div class="form-group row">
                <label for="ProductCode" class="form-label col-md-3">Kode Barang <sup class="font-weight-bold text-danger">*</sup></label>
                <div class="col-md-3">
                    <input type="text" name="ProductCode" id="ProductCode" style="text-transform: uppercase" class="form-control form-control-border">
                </div>
            </div>
            <div class="form-group row">
                <label for="ProductName" class="form-label col-md-3">Nama Barang <sup class="font-weight-bold text-danger">*</sup></label>
                <div class="col-md-3">
                    <input type="text" name="ProductName" id="ProductName" style="text-transform: uppercase" class="form-control form-control-border">                    
                </div>
            </div>
            <div class="form-group row">
                <label for="KodeBarang" class="form-label col-md-3">Kategori Produk <sup class="font-weight-bold text-danger">*</sup></label>
                <div class="col-md-3">
                    <select name="KatProduk" id="KatProduk" class="custom-select form-control-border kategori-produk">
                        <option value="0" readonly>Pilih Kategori Produk</option>
                        <option value="0" readonly></option>
                        @foreach($catProduct as $cp)
                            <option value="{{$cp->category_name}}">{{$cp->category_name}}</option>
                        @endforeach
                    </select>
                </div>               
            </div>
            <div class="form-group row">
                <label for="SmallBarcode" class="form-label col-md-3">Brand <sup class="font-weight-bold text-danger">*</sup></label>
                <div class="col-md-3">
                    <select name="brand" id="brand" class="custom-select form-control-border">
                        <option value="0" readonly>Nama Brand</option>
                        @foreach($manufacture as $mnf)
                            <option value="{{$mnf->manufacture_code}}">{{$mnf->manufacture_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="productImage" class="form-label col-md-3">Gambar Produk</label>
                <div class="col-md-3">
                    <input type="file" name="productImage" id="productImage" class="form-control-file">
                </div>
            </div>
            <div class="form-group row">
                <label for="pajak" class="form-label col-md-3">Pajak Jual</label>
                <div class="col-md-3">
                    <select name="pajak" id="pajak" class="custom-select form-control-border">
                        <option value="0" readonly></option>
                        <option value="PPN">PPN</option>
                        <option value="Non PPN">Non PPN</option>
                    </select>
                </div>
            </div>
            <div class="row mt-5 mb-2">
                <div class="col-md-3"><span class="font-weight-bold text-info">Pengaturan Satuan dan Harga Barang</span></div>
                <div class="col-md-9"><hr></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-valign-middle table-striped table-bordered table-hover" id="tableUkuran">
                            <thead>
                                <tr>
                                    <th colspan="7" class="bg-info font-weight-bold">Setup Barcode & Isi Satuan</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th>Set Barcode</th>
                                    <th>Ukuran</th>
                                    <th>Satuan</th>
                                    <th>Isi</th>
                                    <th>Harga Beli</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <tr>
                                    <td>
                                        <input type="text" name="setBarcode" id="setBarcode" style="text-transform: uppercase" class="form-control form-control-border">
                                    </td>
                                    <td>                                        
                                        <select name="sizeProduct" id="sizeProduct" class="custom-select form-control-border">
                                            <option value="0"></option>
                                            <option value="Besar">Besar</option>
                                            <option value="Kecil">Kecil</option>
                                            <option value="Terkecil">Terkecil</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="unitProduct" id="unitProduct" class="custom-select form-control-border load-input">                        
                                            <option value="0"></option>
                                            @foreach($unit as $uOne)
                                                <option value="{{$uOne->unit_note}}">{{$uOne->unit_note}}</option>                                                
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="volumeProduct" id="volumeProduct" class="form-control form-control-border load-input">
                                    </td>
                                    <td>
                                        <input type="text" name="priceOrder" id="priceOrder" style="text-transform: uppercase" class="form-control form-control-border price-text load-input">
                                    </td>                                                                        
                                    <td>
                                        <button type="button" id="addUnit" class="btn btn-block btn-info add-child">Tambah</button>
                                    </td>
                                </tr>
                            </tbody>                            
                            <tbody id="displaySize">

                            </tbody>                           
                        </table> 
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="7" class="bg-info font-weight-bold">Setup Harga Jual</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th width="20%">Ukuran</th>
                                    <th width="20%">Kategori Harga</th>
                                    <th width="20%">Harga Jual</th>
                                    <th width="20%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="sizeByGroup" id="sizeByGroup" class="custom-select form-control-border">
                                            <option value="0"></option>
                                            <option value="Besar">Besar</option>
                                            <option value="Kecil">Kecil</option>
                                            <option value="Terkecil">Terkecil</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="prodCategory" id="prodCategory" class="custom-select form-control-border">
                                            <option value="0"></option>
                                            @foreach($listGroup as $lG)
                                                <option value="{{$lG->idm_cos_group}}">{{$lG->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    <input type="text" name="priceSell" id="priceSell" style="text-transform: uppercase" class="form-control form-control-border price-text load-input">
                                    </td>
                                    <td class="text-right">                                        
                                        <button type="button" id="addByGroup" class="btn btn-info add-group">Tambah</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="displayPriceGroup">

                            </tbody> 
                        </table>
                    </div>
                </div>
            </div>            
            
            <div class="form-group row">
                <div class="col-2">
                    <button type="submit" id="productSubmit" class="btn btn-block btn-success font-weight-bold">Simpan</button>
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
    });

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let dataIdProd = $("#nextID").val();
        dataTableSize(dataIdProd);
        dataTableGroup(dataIdProd);
        $('#addUnit').on('click', function(){            
            let Size = $("#sizeProduct").find(":selected").val(),
                Unit = $("#unitProduct").find(":selected").val(),
                Volume = $("input[name=volumeProduct]").val(),
                PriceOrder = $("input[name=priceOrder]").val(),
                SetBarcode = $("input[name=setBarcode]").val();            
                $.ajax({
                    type : 'post',
                    url : "{{route('Stock')}}/AddProduct/PostProductSetSizing",
                    data :  {idProduct:dataIdProd,Size:Size,Unit:Unit,Volume:Volume,PriceOrder:PriceOrder,SetBarcode:SetBarcode},
                    success : function(data){        
                        dataTableSize(dataIdProd);
                    }
                });
            $('.load-input').val(''); 
        });

        $('#addByGroup').on('click', function(){            
            let Size = $("#sizeByGroup").find(":selected").val(),                
                prodCategory = $('#prodCategory').find(":selected").val(),
                priceSell = $("#priceSell").val();            
                $.ajax({
                    type : 'post',
                    url : "{{route('Stock')}}/AddProduct/PostProductSetGrouping",
                    data :  {idProduct:dataIdProd, size:Size, prodCategory:prodCategory, priceSell:priceSell},
                    success : function(data){        
                        dataTableGroup(dataIdProd);
                        $("#sizeByGroup").value();
                        $('#prodCategory').value();
                        $("#priceSell").value();
                    }
                });
            $('.load-input').val(''); 
        });

        $('.price-text').mask('000.000.000', {reverse: true});
        let alertNotive = $('.notive-display');

        $("form#FormNewProduct").submit(function(event){
            event.preventDefault();
            $.ajax({
                url : "{{route('Stock')}}/AddProduct/PostProduct",
                type : 'POST',
                data : new FormData(this),
                async : true,
                cache : true,
                contentType : false,
                processData : false,
                success : function (data) {
                    if (data.warning) {
                        $(".notive-display").fadeIn();
                        $("#notiveDisplay").html(data.warning);
                        alertNotive.removeClass('green-alert').addClass('red-alert');
                    }
                    else{
                        $("#displayTableCategory").load("{{route('Stock')}}/ProductMaintenance");
                        $(".notive-display").fadeIn();
                        $("#notiveDisplay").html(data.success);
                        alertNotive.removeClass('red-alert').addClass('green-alert');
                        $("form#FormNewProduct")[0].reset(); 
                    }
                }
            })
        })
    });
    function dataTableSize(dataIdProd){        
        $.ajax({
            type : 'get',
            url : "{{route('Stock')}}/AddProduct/sizeProductInput/"+dataIdProd,
            success : function(response){
                $("#displaySize").html(response);
            }
        });
    }
    function dataTableGroup(dataIdProd){        
        $.ajax({
            type : 'get',
            url : "{{route('Stock')}}/AddProduct/prodCategoryInput/"+dataIdProd,
            success : function(response){
                $("#displayPriceGroup").html(response);
            }
        });
    }
</script>