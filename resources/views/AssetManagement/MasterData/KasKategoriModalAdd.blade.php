<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Kategori</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formAddKategoriKas">
                            <div class="form-group row">
                                <label for="" class="label col-md-3">Nama Kategori</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="namaKategori" id="namaKategori">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success font-weight-bold">Simpan</button>
                                <button type="button" class="btn btn-sm btn-warning font-weight-bold" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(Document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("form#formAddKategoriKas").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('kasKategori')}}/addKategori/postKategori",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    if (data.warning) {
                        alertify.error(data.warning);
                    }
                    else{
                        window.location.reload();
                    }
                },                
            });
            return false;
        });
    })
</script>