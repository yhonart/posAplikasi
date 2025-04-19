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