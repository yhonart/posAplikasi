<form id="formVarianFixed">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="firstNameCode">First Code</label>
                <input type="text" name="firstNameCode" id="firstNameCode" class="form-control form-control-sm" placeholder="Kode Nama Depan, Ex:ABC">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="countVariantPrice">Count Variant Price</label>
                <input type="text" name="countVariantPrice" id="countVariantPrice" class="form-control form-control-sm" placeholder="Ex: 20">
                <small>Jumlah varian harga yang akan dimasukkan</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="minimumPrice">Minimum Price</label>
                <input type="text" name="minimumPrice" id="minimumPrice" class="form-control form-control-sm" placeholder="Ex:1000">
                <small>Start Harga Paling Rendah</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="difference">Difference</label>
                <input type="text" name="difference" id="difference" class="form-control form-control-sm" placeholder="Ex:5000">
                <small>Selisih harga yang akan dimasukkan</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-success" id="posVarianFixed">Save</button>
            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa-solid fa-circle-question"></i></button>

        </div>
    </div>
</form>
<div class="row">
    <div class="col-12">
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <p>
                    Form ini digunakan untuk menghitung varian harga yang memiliki selisih harga yang fix pada setiap harga yang dibuat oleh admin. 
                </p>    
                <p class="font-weight-bold">
                    Contoh :
                </p>
                <dl class="row">
                    <dt class="col-md-4">Input *First Code</dt>
                    <dd class="col-md-4">: ABC</dd>
                </dl>
                <dl class="row">
                    <dt class="col-md-4">Input *Count Variant Price</dt>
                    <dd class="col-md-4">: 5</dd>
                </dl>
                <dl class="row">
                    <dt class="col-md-4">Input *Minimum Price</dt>
                    <dd class="col-md-4">: 5000</dd>
                </dl>
                <dl class="row">
                    <dt class="col-md-4">Input *Difference</dt>
                    <dd class="col-md-4">: 500</dd>
                </dl>
            </div>
            <div>
                <p>Data yang di hasilkan akan berjumlah 5 varian harga dengan masing-masing harga memiliki selisih 500, seperti contoh dibawah ini :</p>
                <img src="{{asset('public/images/DocFlowChart/tableVariantPrice.png')}}" alt="" srcset="" class=" img-fluid">
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $("#posVarianFixed").on('click', function(){
            let valInitialCode = $("#firstNameCode").val(),
                valCount = $("#countVariantPrice").val(),
                valMinimum = $("#minimumPrice").val(),
                valDifference = $("#difference").val(),
                id = "{{$id}}";
            $.ajax({
                type : 'post',
                url : "{{route('sales')}}/mainProduct/newProduct/postNewVarianFixed",
                data :  {valInit:valInitialCode,valCount:valCount,valMinimum:valMinimum,valDif:valDifference,id:id},
                success : function(data){      
                    if (data.warning) {
                        alertify
                        .alert(data.warning, function(){
                            alertify.message('OK');
                        }).set({title:"Warning"});
                    }
                    else if (data.success) {
                        alertify.message(data.success);
                        $("#formVarianFixed")[0].reset();
                        $("#divTableVarianHarga").load("{{route('sales')}}/mainProduct/newProduct/tableVarianPrice/"+id);
                    }
                    else{
                        $("#formVarianFixed")[0].reset();
                        alertify.message(data.success);
                        $("#divTableVarianHarga").load("{{route('sales')}}/mainProduct/newProduct/tableVarianPrice/"+id);
                    }
                }
            }); 
        })
    });
</script>