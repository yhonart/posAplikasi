<?php
$opnameNumber = $getNumber->number_so;
?>
<div class="row mb-2">
    <div class="col-md-12">
        <div class=" btn-group">
            <button class=" btn btn-default btn-sm border-0 font-weight-bold">List Data Opname</button>
            <button class=" btn btn-default btn-sm border-0 font-weight-bold">Input Dok.Stock Opname</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Stockopname {{$opnameNumber}}</h3>
            </div>
            <div class="card-body p-1">
                <table class="table table-sm table-striped table-borderless" id="tableStockOpname">
                    <thead class="text-xs">
                        <tr>
                            <th>#</th>
                            <th width="30%">Product</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Last Stock</th>
                            <th>Total Opname</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#</td>
                            <td class="p-1">
                                <select name="product" id="product" class="form-control form-control-sm" autocomplete="off">
                                    <option value="0|0"></option>
                                    @foreach($getProduct as $gp)
                                        <option value="{{$gp->idm_data_product}}">{{$gp->product_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-1">
                                <select class="form-control form-control-sm" name="satuan" id="satuan">
                                    <option value="0" readonly>--</option>
                                </select>
                            </td>
                            <td class="p-1">
                                <input type="number" name="qty" id="qty" class="form-control form-control-sm" autocomplete="off">
                            </td>
                            <td class="p-1">
                                <input type="text" name="lastStock" id="lastStock" class="form-control form-control-sm" readonly>
                            </td>
                            <td class="p-1">
                                <input type="text" name="total" id="total" class="form-control form-control-sm" readonly>
                            </td>
                            <td class="p-1">
                                <button type="button" class="btn btn-default font-weight-bold btn-xs btn-flat" id="btnSimpanSOP">Simpan</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="inputListOpname"></tbody>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success font-weight-bold btn-block btn-flat" id="btnSimpanOpname">Simpan</button>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="otherPass">
    <input type="hidden" name="hiddenIDInv" id="hiddenIDInv" >
</div>
<script>
    $(function(){
        $('#product').select2({
            width: 'resolve'
        });
        $("#product").focus();   
        loadListData();  
    });

    $(document).ready(function(){
        
        let productID = document.getElementById("product"),
            satuan = document.getElementById("satuan"),
            qty = document.getElementById("qty"),
            laststock = document.getElementById("lastStock"),
            documentNumber = "{{$opnameNumber}}",
            hiddenIDInv = document.getElementById("hiddenIDInv");

        $("#product").change(function(){
            $(".LOAD-SPINNER").fadeIn();
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('sales')}}/displaySatuanProduct/" + productID,
                success : function(response){     
                    $(".LOAD-SPINNER").fadeOut();
                    $("#satuan").html(response).focus();
                }
            });
        });

        satuan.addEventListener("change", function(){
            $(".LOAD-SPINNER").fadeIn();
            let satuanVal = $(this).find(":selected").val(),
                productVal = $("#product").val(),
                location = "{{$getNumber->loc_so}}";
            // alert (location); 
            if(satuanVal !== '0' || satuanVal !== undefined){
                $(".LOAD-SPINNER").fadeOut();
                fetch("{{route('sales')}}/displayStock/"+satuanVal+"/"+productVal+"/"+location)
                .then(response => response.json())
                .then(data => {
                    lastStock.value = data.lastQty;
                    hiddenIDInv.value = data.invID;
                    qty.value = '0';                  
                    $("#qty").focus();
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
            $("#btnSimpanSOP").removeClass('btn-default');         
            $("#btnSimpanSOP").addClass('bg-success');         
        }

        var actqty = document.getElementById("qty");

        actqty.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });

        $("#btnSimpanSOP").on('click', function (event){
            event.preventDefault();
            addActivityItem();
        });

        $("#btnSimpanOpname").on('click', function (event){
            alertify.confirm("Apakah anda yakin ingin menyimpan transaksi ini ?",
            function(){
                alertify.success('Ok');
                $.ajax({
                    type : 'get',
                    url : "{{route('sales')}}/displayStockOpname/submitTransItem/"+documentNumber,
                    success : function(response){
                        loadPage ();
                    }
                });
            },
            function(){
                alertify.error('Cancel');
            });
            
        })

        function addActivityItem() {
            $("#tableStockOpname").fadeOut("slow");
                let prdVal = $("#product").val(),
                    satuanVal = $("#satuan").val(),
                    qtyVal = $("#qty").val(),
                    lastStockVal = $("#lastStock").val(),
                    totalVal = $("#total").val(),
                    invID = $("#hiddenIDInv").val();

            let dataForm = {product:prdVal,satuan:satuanVal,qty:qtyVal,lastStock:lastStockVal,total:totalVal,dokNumber:documentNumber,invID:invID};  
            submitData(dataForm);                  
            $("#tableStockOpname").fadeIn("slow");
        }

        function submitData(dataForm){
            $(".LOAD-SPINNER").fadeIn();
            $.ajax({
                type : 'post',
                url : "{{route('sales')}}/displayStockOpname/postItem",
                data :  dataForm,
                success : function(data){
                    $(".LOAD-SPINNER").fadeOut();   
                    loadPage ();                 
                }
            });
        }

        function loadPage (){
            const linkRoute = "displayStockOpname";
            $("#divContent").load("{{route('sales')}}/"+linkRoute);
        }
    });

    function loadListData(){
        let documentNumber = "{{$opnameNumber}}";
        $.ajax({
            type : 'get',
            url : "{{route('sales')}}/displayStockOpname/tableInputItem/"+documentNumber,
            success : function(response){
                $('#inputListOpname').html(response);
            }
        });
    }
</script>