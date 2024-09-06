<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Tambah Data Brand</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form id="FormNewManufacture">
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-6 col-form-label">Kode Brand</label>
                        <div class="col-sm-6">
                            <input type="text" name="manufactureCode" id="manufactureCode" class="form-control rounded-0 font-weight-bold" autocomplated="off" value="MF{{sprintf('%05d',$next_id)}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-6 col-form-label">Nama Brand</label>
                        <div class="col-sm-6">
                            <input type="text" name="manufactureName" id="manufactureName" class="form-control rounded-0" autocomplated="off" placeholder="E.g. Laptop, PC, etc">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-6 col-form-label">Produk Kategori</label>
                        <div class="col-sm-6">
                            <select name="catID" id="catID" class="form-control rounded-0">
                                <option value="0" readonly></option>
                                @foreach($category as $c)
                                    <option value="{{$c->idm_asset_category}}">{{$c->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-flat font-weight-bold"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
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
        $("#catID").select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modal-global-large')
        });
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('M_Manufacture')}}",
            tableData = "arrayManufacture",
            displayData = $("#displayTableManufacture");

        $("form#FormNewManufacture").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('M_Manufacture')}}/AddManufacture/PostNewManufacture",
                type: 'POST',
                data: new FormData(this),
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
            return false;
        });
    });
</script>