<?php
$statusBarang = array(
    0=>"TIDAK AKTIF",
    1=>"AKTIF",
);
?>
<div class="row mb-2">
    <div class="col-12">
        @if($mProduct->product_status == '1')
        <button class="btn btn-primary btn-sm  font-weight-bold" id="deleteProduct" data-id="{{$mProduct->idm_data_product}}">Hapus Barang Dari Kasir</button>
        @elseif($mProduct->product_status == '0')
        <button class="btn btn-success btn-sm  font-weight-bold" id="activeProduct" data-id="{{$mProduct->idm_data_product}}">Tambahkan Barang Ke Kasir</button>
        @endif
        <button class="btn bg-danger btn-sm  font-weight-bold" id="deletePermanent" data-id="{{$mProduct->idm_data_product}}">Hapus Permanent</button>
        <p class="text-info font-weight-bold float-right"><i class="fa-solid fa-circle-info"></i> Gunakan ENTER untuk menyimpan data ...</p>
    </div>
</div>
<form class="form">
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Status Barang</label>
        <div class="col-4">
            <input type="text" name="prodCode" id="productCode" class="form-control form-control-sm font-weight-bold " value="{{$statusBarang[$mProduct->product_status]}}" onchange="saveMasterBarang(this,'m_product','product_code','{{$mProduct->idm_data_product}}','idm_data_product','{{$id}}')" readonly>
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Kode Barang</label>
        <div class="col-4">
            <input type="text" name="prodCode" id="productCode" class="form-control form-control-sm " value="{{$mProduct->product_code}}" onchange="saveMasterBarang(this,'m_product','product_code','{{$mProduct->idm_data_product}}','idm_data_product','{{$id}}')" readonly>
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Nama Barang</label>
        <div class="col-4">
            <input type="text" name="prodCode" id="productCode" class="form-control form-control-sm " value="{{$mProduct->product_name}}" onchange="saveMasterBarang(this,'m_product','product_name','{{$mProduct->idm_data_product}}','idm_data_product','{{$id}}')">
        </div>
    </div>
    <div class="form-group row mb-4">
        <label class="col-3 align-self-end">Kategori Barang</label>
        <div class="col-4">
            <select name="productCategory" class="form-control form-control-sm " onchange="saveMasterBarang(this,'m_product','product_category','{{$mProduct->idm_data_product}}','idm_data_product','{{$id}}')">
                <option value="{{$mProduct->product_category}}">{{$mProduct->product_category}}</option>
                @foreach($category as $c)
                    <option value="{{$c->category_name}}">{{$c->category_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
<!--SET BRAND & STOCK -->
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Brand</label>
        <div class="col-3">
            <select name="brand" class="form-control form-control-sm " onchange="saveMasterBarang(this,'m_product','brand','{{$mProduct->idm_data_product}}','idm_data_product','{{$id}}')">
                <option value="{{$mProduct->brand}}">{{$mProduct->brand}}</option>
                @foreach($brand as $b)
                    <option value="{{$b->manufacture_name}}">{{$b->manufacture_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Set Minimum Stock</label>
        <div class="col-3">
            <input type="text" name="setMinimumStock" value="{{$mProduct->minimum_stock}}" class="form-control form-control-sm " onchange="saveMasterBarang(this,'m_product','minimum_stock','{{$mProduct->idm_data_product}}','idm_data_product','{{$id}}')">
        </div>
    </div>
<!--START SATUAN -->
<a class="btn btn-primary mb-1 mt-1 font-weight-bold " data-toggle="collapse" href="#collapseSatuan" role="button" aria-expanded="false" aria-controls="collapseSatuan">
    <i class="fa-solid fa-plus"></i> Tambah Pengaturan Satuan
</a>
<div class="collapse" id="collapseSatuan">
    <div class="card border border-info">
        <div class="card-body text-xs table-responsive">
            <table class="table table-sm table-borderless p-0">
                <tbody>
                    <tr>
                        <form id="formNewUnit">
                        <input type="hidden" name="stock" class="form-control form-control-sm" placeholder="Stock">
                        <input type="hidden" name="prdunID" value="{{$id}}">
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
                                @foreach($mUnit as $mU2)
                                    <option value="{{$mU2->unit_note}}">{{$mU2->unit_note}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="addVolumeBarang" class="form-control form-control-sm " placeholder="Satuan Isi">
                        </td>
                        <td>
                            <input type="text" name="setBarcode" class="form-control form-control-sm " placeholder="Set Barcode">
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm BTN-ADD-UNIT " id="btnAddUnit">Tambah</button>
                        </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <table class="table table-sm table-valign-middle table-borderless table-hover">
        <thead>
            <tr>
                <th></th>
                <th class="bg-gray-dark">Satuan</th>
                <th>Volume</th>
                <th>Set Barcode</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($mProdUnit as $unit1)
                <?php
                    if($unit1->size_code=='3'){
                        $setReadOnly = "readonly";
                    }else{
                        $setReadOnly = "";
                    }
                ?>
                <tr>
                    <td width="25%" class="bg-light">
                        {{$unit1->product_size}}
                    </td>
                    <td class="bg-gray-dark">
                        <select name="satuanBesar[]" class="form-control form-control-sm " onchange="saveMasterBarang(this,'m_product_unit','product_satuan','{{$unit1->idm_product_satuan}}','idm_product_satuan','{{$id}}')">
                            <option>{{$unit1->product_satuan}}</option>
                            <option style="color:red" value="DELL">Hapus Satuan Besar</option>
                            @foreach($mUnit as $mU1)
                                <option value="{{$mU1->unit_note}}">{{$mU1->unit_note}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="volume[]" class="form-control form-control-sm " onchange="saveMasterBarang(this,'m_product_unit','product_volume','{{$unit1->idm_product_satuan}}','idm_product_satuan','{{$id}}')" value="{{$unit1->product_volume}}" {{$setReadOnly}}>
                    </td>
                    <td>
                       <input type="text" name="setBarcode[]" class="form-control form-control-sm " onchange="saveMasterBarang(this,'m_product_unit','set_barcode','{{$unit1->idm_product_satuan}}','idm_product_satuan','{{$id}}')" value="{{$unit1->set_barcode}}" {{$setReadOnly}}>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-danger  DELLUNIT" data-id="{{$unit1->idm_product_satuan}}"><i class="fa-solid fa-xmark"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<!--PENGATURAN HARGA BARANG -->
<hr class="border-danger">
<h5 class="text-info">Harga Barang</h5>
<a class="btn btn-primary mb-1 mt-1  font-weight-bold" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    <i class="fa-solid fa-plus"></i> Tambah Pengaturan Harga
</a>
<div class="collapse" id="collapseExample">
    <div class="card border border-info">
        <div class="card-body text-xs">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td>
                            <select class="form-control form-control-sm " name="unitHarga" id="unitHarga">
                                <option value="0" readonly>Satuan</option>
                                @foreach($mProdUnit as $mDataUnit)
                                    <option value="{{$mDataUnit->product_size}}">{{$mDataUnit->product_size}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="form-control form-control-sm " name="priceOrder" autocomplete="off" placeholder="Harga Pembelian">
                        </td>
                        <td>
                            <input class="form-control form-control-sm " name="priceSell" autocomplete="off" placeholder="Harga Jual">
                        </td>
                        <td>
                            <select class="form-control form-control-sm " name="cosGroup" id="cosGroup">
                                    <option value="0" readonly>Tipe Pelangan</option>
                                @foreach($cosGroup as $cG)
                                    <option value="{{$cG->idm_cos_group}}">{{$cG->group_name}}</option>
                                @endforeach
                            </select>
                        </td> 
                        <td><button type="button" class="btn btn-info " id="btnTambahHarga">Tambah</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 table-responsive">
        @if($countPrdSell>='1')
        <table class="table">
            <thead>
                <tr>
                    <th width="10%"></th>
                    <th class="bg-gray-dark">Harga Beli <i class="fa-solid fa-rupiah-sign float-right"></i></th>
                    @foreach($cosGroup as $cg)
                    <th>{{$cg->group_name}} <i class="fa-solid fa-rupiah-sign float-right text-info"></i></th>
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $countDataSize = '0';
                ?>
                @foreach($mProdUnit as $size)
                    <tr>
                        <td>
                            {{$size->product_size}} <br>
                        </td>
                        <td class="bg-gray-dark">
                            @if($size->size_code == '1')
                                <input class="form-control form-control-sm text-right EDIT-PRICE " name="priceOrder" value="{{$size->product_price_order}}" onchange="saveMasterBarang(this,'m_product_unit','product_price_order','{{$size->idm_product_satuan}}','idm_product_satuan','{{$id}}')">
                            @else
                                <input class="form-control form-control-sm text-right " value="{{$size->product_price_order}}" readonly>
                            @endif
                        </td>
                        @foreach($cosGroup as $cg1)
                            <td>
                                @foreach($mPriceSell as $pSell)
                                    @if($pSell->size_product == $size->product_size AND $pSell->cos_group==$cg1->idm_cos_group)
                                        <input class="form-control form-control-sm text-right EDIT-PRICE " name="sell[]" value="{{$pSell->price_sell}}" onchange="saveMasterBarang(this,'m_product_price_sell','price_sell','{{$pSell->idm_price_sell}}','idm_price_sell','{{$id}}')">
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-12">
        <p>* Masukkan nilai 0 pada harga jual apabila tidak digunakan.</p>
        <button type="button" class="btn btn-success btn-sm elevation-1" id="btnSimpanEditData">SIMPAN</button>
    </div>
</div>
</form>
<div class="row">
    <div class="col-md-12">
        <img class="img-fluid pad" src="{{asset('public/images/Upload/Product')}}/{{$id}}/{{$mProduct->file_name}}" alt="Photo" width="30%">
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function(){
        $(".EDIT-PRICE").mask('000.000.000',{
                reverse: true,
            });
    })
    function saveMasterBarang(editTableObj,tableName,column,id,tableID,idProd) {
        let routeID = "{{$id}}";
        $.ajax({
            url: "{{route('Stock')}}/ProductMaintenance/postEditProduct",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.value+'&id='+id+'&tableID='+tableID+'&idProd='+idProd,
            success: function(data){
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil disimpan'
                })
                funcLoad(routeID);
            }
        });
    } 
    $(document).ready(function() {
        $('.DELLUNIT').on('click', function () {
            let element = $(this) ;
            let id = element.attr("data-id");
            let routeID = "{{$id}}";
            $.ajax({
                type : 'get',
                url : "{{route('Stock')}}/ProductMaintenance/deleteUnit/"+id,
                success : function(response){
                    funcLoad(routeID);
                }
            });
        });
        
        let el_addUnit = $('.BTN-ADD-UNIT');
        
        $('#btnAddUnit').on('click', function () {
            let size = $("#addPrdSize").find(":selected").val(),
                satuan = $("#addSatuan").find(":selected").val(),
                volume = $("input[name=addVolumeBarang]").val(),
                setBarcode = $("input[name=setBarcode]").val(),
                stock = $("input[name=stock]").val();
                id = $("input[name=prdunID]").val();
            let routeID = "{{$id}}";
            $.ajax({
                url: "{{route('Stock')}}/ProductMaintenance/postAddUnit",
                type: 'POST',
                data: {prdID:id,size:size,satuan:satuan,volume:volume,setBarcode:setBarcode,stock:stock},
                success: function (data) {                    
                    funcLoad(routeID);
                }
            });
        });
        
        $('#btnTambahHarga').on('click', function(){            
            let unitHarga = $('#unitHarga').find(":selected").val(),
                priceOrder = $("input[name=priceOrder]").val(),
                priceSell = $("input[name=priceSell]").val(),
                cosGroup = $('#cosGroup').find(":selected").val(),
                routeID = "{{$id}}";
                
                $.ajax({
                    type : 'post',
                    url : "{{route('Stock')}}/AddProduct/PostProductSetGrouping",
                    data :  {unitHarga:unitHarga,priceOrder:priceOrder,priceSell:priceSell,cosGroup:cosGroup,routeID:routeID},
                    success : function(data){        
                        funcLoad(routeID);
                    }
                });
            $('.load-input').val(''); 
        });
        $('#deleteProduct').on('click', function(){ 
            let element = $(this) ;
            let id = element.attr("data-id");
            let routeID = "{{$id}}";
            alertify.prompt("Apakah anda yakin ingin menghapus produk ini dari kasir ?, berikan alasannya [OPTIONAL]", "",
                function(evt, value ){
                    alertify.success('Ok: ' + value);
                    $.ajax({
                        type : 'get',
                        url : "{{route('Stock')}}/ProductMaintenance/deleteProduct/"+id,
                        success : function(response){
                            funcLoad(routeID);
                        }
                    }); 
                },
                function(){
                    alertify.error('Cancel');
                }).set({title:"Menghapus Data"})
            ;
        });
        $('#deletePermanent').on('click', function(){ 
            let element = $(this) ;
            let id = element.attr("data-id");
            alertify.prompt("Apakah anda yakin ingin menghapus produk ini ?, berikan alasannya [OPTIONAL]", "",
                function(evt, value ){
                    alertify.success('Ok: ' + value);
                    $.ajax({
                        type : 'get',
                        url : "{{route('Stock')}}/ProductMaintenance/deleteProductPermanent/"+id,
                        success : function(response){
                            window.location.reload();
                        }
                    }); 
                },
                function(){
                    alertify.error('Cancel');
                }).set({title:"Menghapus Data"})
            ;
        });
        $('#activeProduct').on('click', function(){ 
            let element = $(this) ;
            let id = element.attr("data-id");
            let routeID = "{{$id}}";
            alertify
              .alert("Apakah anda yakin ingin menambahkan barang kedalam kasir?", function(){
                  $.ajax({
                        type : 'get',
                        url : "{{route('Stock')}}/ProductMaintenance/activeProduct/"+id,
                        success : function(response){
                            // location.reload();
                            funcLoad(routeID);
                        }
                    }); 
                alertify.message('OK');
              }).set({title:"Mengaktifkan Barang"});
        });
    });
    function funcLoad(routeID){        
        $.ajax({
            type:'get',
            url:"{{route('Stock')}}/ProductMaintenance/MenuPriceEdit/"+routeID, 
            success : function(response){
                $("#detailProduct").html(response);
            }           
        }); 
    }
</script>