<form class="form">
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Kode Barang</label>
        <div class="col-4">
            <input type="text" name="prodCode" id="productCode" class="form-control form-control-border border-width-2 border-info" value="">
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Nama Barang</label>
        <div class="col-4">
            <input type="text" name="prodCode" id="productCode" class="form-control form-control-border border-width-2 border-info" value="{{$mProduct->product_name}}">
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Kategori Barang</label>
        <div class="col-4">
            <input type="text" name="prodCode" id="productCode" class="form-control form-control-border border-width-2 border-info" value="{{$mProduct->product_category}}">
        </div>
    </div>
    
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Satuan Besar</label>
        <div class="col-3">
            <select name="satuanBesar" class="form-control form-control-border border-width-2 border-info">
                <option value="0"></option>
                @foreach($mUnit as $mU1)
                    <option value="{{$mU1->unit_note}}">{{$mU1->unit_note}}</option>
                @endforeach
            </select>
        </div>
        <label class="col-3 align-self-end text-right">Isi Satuan Besar</label>
        <div class="col-3">
            <input type="text" name="satuanBesar" id="satuanBesar" class="form-control form-control-border border-width-2 border-info" value="">
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Satuan Kecil</label>
        <div class="col-3">
            <select name="satuanKecil" class="form-control form-control-border border-width-2 border-info">
                @foreach($mUnit as $mU2)
                    <option value="{{$mU2->unit_note}}">{{$mU2->unit_note}}</option>
                @endforeach
            </select>
        </div>
        <label class="col-3 align-self-end text-right">Isi Satuan Kecil</label>
        <div class="col-3">
            <input type="text" name="satuanKecil" id="satuanKecil" class="form-control form-control-border border-width-2 border-info" value="">
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-3 align-self-end">Satuan konv.</label>
        <div class="col-3">
            <select name="satuanKonv" class="form-control form-control-border border-width-2 border-info">
                @foreach($mUnit as $mU3)
                    <option value="{{$mU3->unit_note}}">{{$mU3->unit_note}}</option>
                @endforeach
            </select>
        </div>
        <label class="col-3 align-self-end text-right">Isi Satuan Konv.</label>
        <div class="col-3">
            <input type="text" name="satuanKonv" id="satuanKonv" class="form-control form-control-border border-width-2 border-info" value="">
        </div>
    </div>
</form>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Edit Table
    function showEdit(editTableObj) {
        $(editTableObj).css("background","#c7d2fe");
        $(editTableObj).mask('000.000.000', {reverse: true});
    }
    function saveToDatabase(editTableObj,tableName,column,id,priceId) {
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('TransProduct')}}",
            tableData = "StockBarang",
            displayData = $("#diplayTransaction");

        $(editTableObj).css("background","#FFF");
        $.ajax({
            url: "{{route('Stock')}}/ProductMaintenance/PostEditProductPrice",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.innerHTML+'&id='+id+'&priceId='+priceId,
            success: function(data){
                $(editTableObj).css("background","#FDFDFD");
                global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
            }
        });
    } 
</script>