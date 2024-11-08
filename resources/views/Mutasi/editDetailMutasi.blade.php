<hr>
<div class="row mb-2">
    <div class="col-12">
        <a class="btn btn-sm btn-default  font-weight-bold" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <i class="fa-solid fa-circle-info"></i> Dokumen Mutasi
        </a>
        <button type="submit" class="btn btn-sm btn-default font-weight-bold " id="submitDataMutasi" data-number="{{$tbMutasi->number}}"><i class="fa-solid fa-circle-check"></i> Simpan Perubahan</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
            <input type="hidden" name="numberMutasi" id="numberMutasi" value="{{$tbMutasi->number}}">
            <div id="editDocMutasi"></div>
          </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-body">
            <form class="form mb-2" id="formSubmitUpdate">
                <div class="form-group">
                </div>
            </form>
            <table class="table table-sm table-hover table-valign-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width="30%">Nama Barang</th>
                        <th>Satuan</th>
                        <th>Stock | <small>Barang Asal</small></th>
                        <th width="10%">Mutasi</th>
                        <th width="30%">Keterangan</th>
                    </tr>
                </thead>
                    <tbody>
                        <form id="formInputMutasiBarang">
                            <tr>
                                <td class="border border-1">
                                    <input type="hidden" class="form-control form-control-sm" name="invID" id="invID">
                                    <input type="hidden" class="form-control form-control-sm" name="warehouse" id="warehouse" value="{{$tbMutasi->from_loc}}">
                                </td>
                                <td class="p-0">
                                    <select class="form-control form-control-sm " name="mProduct" id="mProduct">
                                        <option value="0"></option>
                                        @foreach($mProduct as $mp)
                                        <option value="{{$mp->idm_data_product}}">{{$mp->product_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-0">
                                    <select class="form-control form-control-sm " name="satuan" id="satuan">
                                        <option value="0"></option>
                                    </select>
                                </td>
                                <td class="p-0">
                                    <input type="text" class="form-control form-control-sm " name="lastStock" id="lastStock" readonly>
                                </td>
                                <td class="p-0">
                                    <input type="number" class="form-control form-control-sm " name="qty" id="qty">
                                </td>
                                <td class="p-0">
                                    <input type="text" class="form-control form-control-sm " name="keterangan" id="keterangan">
                                </td>
                                <td class="p-0">
                                    <button class="btn border-0 elevation-0 btn-default " id="btnSubmit"><i class="fa-solid fa-check"></i></button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                    <tbody id="loadListMutasi"></tbody>
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
        let idparam = "{{$tbMutasi->number}}";
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
        if(parseInt(qtyInput) > parseInt(lastStockInput)){
            alertify
            .alert("Silahkan cek kembali, qty yang dimasukkan tidak boleh melebihi stock!", function(){
                alertify.message('Mutasi barang dibatalkan!');
            });
        }else{
            let dataForm = {product:productInput,satuan:satuanInput,lastStock:lastStockInput,qty:qtyInput,noMutasi:noMutasi,invID:invID};
            submitData(dataForm);
        } 
    }
    
    function submitData(dataForm){
        $.ajax({
            type : 'post',
            url : "{{route('mutasi')}}/formEntryMutasi/submitDataBarang",
            data :  dataForm,
            success : function(data){
                $("#mProduct").val(null).trigger('change');
                $('input[name=lastStock').val('');
                $('input[name=qty').val('');
                $("#mProduct").focus().select();
                loadListData();
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
        // spinner.fadeIn("slow");
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/formEntryMutasi",
            success : function(response){
                spinner.fadeOut("slow");
                divPanel.fadeIn("slow");
                $('#divPanelMutasi').html(response);
            }
        });
    }
    
    
    
</script>