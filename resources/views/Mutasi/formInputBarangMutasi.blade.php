<hr>
<div class="row mb-2">
    <div class="col-12">
        <div class="d-flex flex-row-reverse">
            <button class="btn btn-default btn-sm font-weight-bold border-0" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-file-pen"></i> Dokumen Mutasi
            </button>
            <button type="submit" class="btn btn-success font-weight-bold btn-sm ml-2 border-0" id="submitDataMutasi" data-number="{{$numberAct}}"><i class="fa-solid fa-circle-check"></i> Simpan Transaksi</button>    
            <input type="hidden" class="form-control form-control-sm text-right" name="sumTotalMutasi" id="sumTotalMutasi" value="{{$sumMutasi->totalMoving}}">
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <div class="collapse" id="collapseExample">
          <div class="card card-body">
            <div id="editDocMutasi"></div>
          </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-body table-responsive p-1">
            <table class="table table-sm table-valign-middle ">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width="30%">Nama Barang</th>
                        <th>Satuan</th>
                        <th>Stock</th>
                        <th width="10%">Mutasi</th>
                        <th width="30%">Keterangan</th>
                        <th>#</th>
                    </tr>
                </thead>
                @if($countActive >= '1')
                    <tbody>
                        <form id="formInputMutasiBarang">
                            <tr>
                                <td class="text-center">
                                    <input type="hidden" name="numberMutasi" id="numberMutasi" value="{{$numberAct}}">
                                    <input type="hidden" class="form-control form-control-sm" name="invID" id="invID">
                                    <input type="hidden" class="form-control form-control-sm" name="warehouse" id="warehouse" value="{{$tbMutasiL->from_loc}}">
                                    #
                                </td>
                                <td>
                                    <select class="form-control form-control-sm " name="mProduct" id="mProduct">
                                        <option value="0"></option>
                                        @foreach($mProduct as $mp)
                                        <option value="{{$mp->idm_data_product}}">{{$mp->product_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control form-control-sm " name="satuan" id="satuan">
                                        <option value="0"></option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm " name="lastStock" id="lastStock" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm " name="qty" id="qty" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm " name="keterangan" id="keterangan" autocomplete="off">
                                </td>
                                <td>
                                    <button class="btn border-0 elevation-0 btn-default " id="btnSubmit"><i class="fa-solid fa-check"></i></button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                    <tbody id="loadListMutasi"></tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#mProduct').select2({
          width: 'resolve'
        });
        $("#mProduct").focus();
        loadListData();
        let idparam = "{{$numberAct}}";
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/formEntryMutasi/editDocMutasi/" + idparam,
            success : function(response){     
                $("#editDocMutasi").html(response);
            }
        });
    })
    
    $(document).ready(function(){
        let satuan =  document.getElementById('satuan'),
            lastStock =  document.getElementById('lastStock'),
            invID =  document.getElementById('invID');
        
        $("#mProduct").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('mutasi')}}/listSatuan/satuan/" + productID,
                success : function(response){     
                    $("#satuan").html(response).focus();
                }
            });
        })
        
        satuan.addEventListener("change", function(){
            let satuanVal = $(this).find(":selected").val(),
                productVal = $("#mProduct").val(),
                fromLoc = $("#warehouse").val();
                
            if(satuanVal !== '0' || satuanVal !== undefined){
                fetch("{{route('mutasi')}}/formEntryMutasi/entryStock/"+satuanVal+"/"+productVal+"/"+fromLoc)
                .then(response => response.json())
                .then(data => {
                    lastStock.value = data.lastQty;
                    invID.value = data.invID;
                    $("#qty").val(0).focus().select();
                    if(data.lastQty == '0'){
                        alertify
                        .alert("Stock di lokasi 0, silahkan lakukan stock opname terlebih dahulu !", function(){
                            alertify.message('Mutasi barang dibatalkan!');
                        });
                    }
                })
            }
        });
        
        $("#qty").on('input', computeSaldo);
        
        function computeSaldo(){
            // let lastStockVal = $("#lastStock").val(),
            //     qty = $("#qty").val();
                
            // if (typeof qty == "undefined" || typeof qty == "0") {
            //     return
            // }
            // $("#total").val(parseFloat(qty) - parseFloat(lastStockVal));
            $("#btnSubmit").focus().removeClass('btn-default');
            $("#btnSubmit").focus().addClass('bg-success');
        }

        $("#btnSubmit").on('click', function(e){
            e.preventDefault();
            addActivityItem();
        });
        
        var actQty = document.getElementById("qty");
        
        actQty.addEventListener('keydown', function(event) {  
            if (event.keyCode === 13) {
                event.preventDefault();
                addActivityItem();
            }   
        });
        
        $('#submitDataMutasi').on('click', function (e) {
            e.preventDefault();
            let sumTotalMutasi = $("#sumTotalMutasi").val(),
                noMutasi = $("#numberMutasi").val();
            alertify.prompt("Masukkan catatan mutasi apabila ada !", "",
                function(evt, value ){
                    alertify.success('Ok: ' + value);
                    $.ajax({
                        type : 'post',
                        url : "{{route('mutasi')}}/formEntryMutasi/submitTotalMutasi",
                        data :  {sumTotalMutasi:sumTotalMutasi,noMutasi:noMutasi},
                        success : function(data){
                            window.location.reload();
                        }
                    });
                },
                function(){
                    alertify.error('Cancel');
                }).set({title:"Submit Data Mutasi"});
            
        });
        
    });
    
    function addActivityItem() {
        let productInput = $("#mProduct").val(),
            satuanInput = $("#satuan").val(),
            lastStockInput = $("#lastStock").val(),
            qtyInput = $("#qty").val(),
            noMutasi = $("#numberMutasi").val(),
            invID = $("#invID").val();
        let dataForm = {product:productInput,satuan:satuanInput,lastStock:lastStockInput,qty:qtyInput,noMutasi:noMutasi,invID:invID};
        submitData(dataForm);
    }
    
    function submitData(dataForm){
        $.ajax({
            type : 'post',
            url : "{{route('mutasi')}}/formEntryMutasi/submitDataBarang",
            data :  dataForm,
            success : function(data){
                $("form#formInputMutasiBarang")[0].reset();
                $("#mProduct").focus();
                vTableMutasi();
                
            }
        });
    }
    
    function loadTableData(){
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/listInputBarang",
            success : function(response){
                $('#divPanelMutasi').html(response);
            }
        });
    }
    
    function loadListData(){
        let noMutasi = $("#numberMutasi").val();
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/formEntryMutasi/listBarang/"+noMutasi,
            success : function(response){
                $('#loadListMutasi').html(response);
            }
        });
    }
    
    function vTableMutasi(){
        let route = "formEntryMutasi";
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/"+route,
            success : function(response){
                $('#displayMutasi').html(response);
            }
        });
    }
    
    
    
</script>