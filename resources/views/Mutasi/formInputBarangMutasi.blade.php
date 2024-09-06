<hr>
<div class="row mb-2">
    <div class="col-12">
        <a class="font-weight-bold mb-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <i class="fa-solid fa-file-pen"></i> Edit Dokumen Mutasi
        </a>
        <input type="hidden" class="form-control form-control-sm text-right" name="sumTotalMutasi" id="sumTotalMutasi" value="{{$sumMutasi->totalMoving}}">
        <div class="collapse" id="collapseExample">
          <div class="card card-body">
            <div id="editDocMutasi"></div>
          </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-body table-responsive">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success font-weight-bold elevation-1 btn-flat mb-2 btn-sm" id="submitDataMutasi" data-number="{{$number}}"><i class="fa-solid fa-circle-check"></i> Simpan Transaksi</button>
                </div>
            </div>
            <table class="table table-sm table-bordered table-hover table-valign-middle">
                <thead class="bg-gradient-purple">
                    <tr>
                        <th>No.</th>
                        <th width="30%">Nama Barang</th>
                        <th>Satuan</th>
                        <th>Stock</th>
                        <th width="10%">Mutasi</th>
                        <th width="30%">Keterangan</th>
                        <th></th>
                    </tr>
                </thead>
                @if($countActive >= '1')
                    <tbody>
                        <form id="formInputMutasiBarang">
                            <tr>
                                <td class="text-center">
                                    <input type="hidden" name="numberMutasi" id="numberMutasi" value="{{$number}}">
                                    <input type="hidden" class="form-control form-control-sm" name="invID" id="invID">
                                    <input type="hidden" class="form-control form-control-sm" name="warehouse" id="warehouse" value="{{$tbMutasiL->from_loc}}">
                                    #
                                </td>
                                <td>
                                    <select class="form-control form-control-sm rounded-0" name="mProduct" id="mProduct">
                                        <option value="0"></option>
                                        @foreach($mProduct as $mp)
                                        <option value="{{$mp->idm_data_product}}">{{$mp->product_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control form-control-sm rounded-0" name="satuan" id="satuan">
                                        <option value="0"></option>
                                    </select>
                                </td>
                                <td>
                                    <input type"text" class="form-control form-control-sm rounded-0" name="lastStock" id="lastStock" readonly>
                                </td>
                                <td>
                                    <input type"text" class="form-control form-control-sm rounded-0" name="qty" id="qty">
                                </td>
                                <td>
                                    <input type"text" class="form-control form-control-sm rounded-0" name="keterangan" id="keterangan">
                                </td>
                                <td></td>
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
        let idparam = "{{$number}}";
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