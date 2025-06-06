<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Kategori</h3>
            </div>
            <div class="card-body">
                <form id="formNewCategory">
                    <input type="hidden" name="initialCode" id="initialCode" value="ITC02">
                    <div class="form-group row">
                        <label for="categoryCode" class="form-label col-md-4">Kode Kategori</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control form-control-sm" name="categoryCode" id="categoryCode">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="categoryName" class="form-label col-md-4">Nama Kategori</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control form-control-sm" name="categoryName" id="categoryName">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success" id="saveCategory">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    let data_path = "mainCategory",
        route = "{{route('sales')}}";

    $("form#FormNewCategory").submit(function(event){
        event.preventDefault();
        $.ajax({
            url: "{{route('M_Category')}}/AddCategory/PostNewCategory",
            type: 'POST',
            data: new FormData(this),
            async: true,
            cache: true,
            contentType: false,
            processData: false,
            success: function (data) {                    
                if (data.warning) {
                    alertify
                    .alert(data.warning, function(){
                        alertify.message('OK');
                    });
                }
                else{
                    $("#divContent").load(route+'/'+path);
                }
            },                
        });
        return false;
    });
});
</script>