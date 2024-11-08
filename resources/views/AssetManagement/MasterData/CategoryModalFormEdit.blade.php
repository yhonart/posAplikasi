<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Edit Kategori</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form id="FormEditCategory">
                    <input type="hidden" name="categoryId" value="{{$id}}">
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-6 col-form-label">Kode Kategori</label>
                        <div class="col-sm-6">
                            <input type="text" name="categoryCode" id="categoryCode" class="form-control  font-weight-bold" autocomplate="off" value="CAT{{sprintf('%05d',$id)}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CatName" class="col-sm-6 col-form-label">Nama Kategori</label>
                        <div class="col-sm-6">
                            <input type="text" name="categoryName" id="categoryName" class="form-control " autocomplate="off" value="{{$CategoryEdit->category_name}}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success  font-weight-bold"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
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
            routeIndex = "{{route('M_Category')}}",
            tableData = "arrayCategory",
            displayData = $("#displayTableCategory");

        $("form#FormEditCategory").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('M_Category')}}/arrayCategory/PostEditCategory",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    if (data.warning) {
                        $(".notive-display").fadeIn('slow');
                        $("#notiveDisplay").html(data.warning);
                    }
                    else{
                        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                        global_style.hide_modal();
                    }
                },                
            });
            return false;
        });
    });
</script>