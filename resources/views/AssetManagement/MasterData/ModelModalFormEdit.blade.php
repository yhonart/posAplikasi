<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Edit Model</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body text-xs">
                <form id="FormNewModel">
                    <input type="hidden" name="idModelEdit" id="idModelEdit" value="{{$ModelEdit->idm_asset_model}}">
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-4 col-form-label">Kode Model <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="modelCode" id="modelCode" class="form-control REQUIRED" autocomplate="off" value="{{$ModelEdit->model_code}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-4 col-form-label">Nama Model <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="modelName" id="modelName" class="form-control" autocomplated="off" value="{{$ModelEdit->model_name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-4 col-form-label">Model Kategori <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="modelCategory" id="modelCategory" class="form-control">
                                <option value="{{$ModelEdit->category_note}}" readonly>✔ {{$ModelEdit->category_note}}</option>
                                @foreach($mCategory as $mc)
                                    <option value="{{$mc->category_name}}">{{$mc->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-4 col-form-label">Brand <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="modelManufacture" id="modelManufacture" class="form-control">
                                <option value="{{$ModelEdit->manufacture_note}}" readonly>✔ {{$ModelEdit->manufacture_note}}</option>
                                @foreach($mManufacture as $mmf)
                                    <option value="{{$mmf->manufacture_name}}">{{$mmf->manufacture_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-4 col-form-label">Catatan <sub class="text-muted">Optional</sub></label>
                        <div class="col-sm-8">
                            <input type="text" name="modelNote" id="modelNote" class="form-control" autocomplated="off" value="{{$ModelEdit->model_note}}">
                        </div>
                    </div>                                                            
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-6 col-form-label">Gambar <sub class="text-muted">Optional</sub></label>
                        <div class="col-sm-6 custom-file">
                            <input type="file" name="modelFile" id="modelFile" class="custom-file-input">
                            <label class="custom-file-label" for="modelFile">Ambil Gambar</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">
                            <select name="modelStatus" id="modelStatus" class="form-control">
                                <option value="{{$ModelEdit->model_status}}" readonly>✔ {{$ModelEdit->model_status}}</option>
                                <option value="0" readonly></option>
                                <option value="Ready">Ready</option>
                                <option value="Out of date">Out of date</option>
                            </select>                            
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-12">
                            @if($ModelEdit->model_file_name == "")
                                <span class="text-muted"><i class="fa-solid fa-triangle-exclamation"></i> No image</span>
                            @else
                                <img src="{{asset('public/images/Upload/Model')}}/{{$ModelEdit->model_file_name}}" alt="" srcset="" class="img-fluid img-thumbnail">                             
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="button" id="btnEditModel" class="btn btn-info">Simpan</button>
                    </div>
                </form>                
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <span class="notive-display bg-danger p-2 rounded rounded-2 elevation-2 font-weight-bold" id="notiveDisplay" style="display:none;"></span>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('M_Model')}}",
            tableData = "arrayModel",
            displayData = $("#displayTableModel");

            
        $('#btnEditModel').on('click', function(){

            let val_mCode = $("input[name=modelCode]").val(),
                val_mName = $("#modelName").val(),
                val_mCategory = $("#modelCategory").find(":selected").val(),
                val_mManufacture = $('#modelManufacture').find(":selected").val();            
            
            if(val_mCode == '' || val_mName == ''){
                $(".notive-display").fadeIn();
                $("#notiveDisplay").html("Kode dan Nama Model Harus Diisi !");
            }
            else if(val_mManufacture == 0 || val_mCategory == 0){
                $(".notive-display").fadeIn();
                $("#notiveDisplay").html("Category dan Manufacture Harus Diisi !");
            }
            else{
                let data_form = new FormData(document.getElementById("FormNewModel"));
                $.ajax({
                    url: "{{route('M_Model')}}/arrayModel/PostEditModel",
                    type: 'POST',
                    data: data_form,
                    async: true,
                    cache: true,
                    contentType: false,
                    processData: false,
                    success: function (data) {                    
                        if (data.warning) {
                            $(".notive-display").fadeIn();
                            $("#notiveDisplay").html(data.warning);
                        }
                        else{
                            global_style.hide_modal();
                            global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                        }
                    },                
                });
            }
        });
    });
</script>