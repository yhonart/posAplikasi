<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Sub Kategori</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formAddSubKategori">
                            <div class="form-group row">
                                <label for="" class="label col-md-3">Nama Sub Kategori</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="namaSubKategori" id="namaSubKategori">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="label col-md-3">Kategori</label>
                                <div class="col-md-4">
                                    <select name="kategori" id="kategori" class="form-control form-control-sm">
                                        <option value="0">Pilih Dari Kategori</option>
                                        @foreach($kategori as $k)
                                            <option value="{{$k->idm_cat_kas}}">{{$k->cat_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="label col-md-3">Memerlukan Dokumen Penunjang</label>
                                <div class="col-md-4">
                                    <select name="lampiran" id="lampiran" class="form-control form-control-sm">
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa-solid fa-circle-question"></i>
                                    </a>                                 
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success font-weight-bold">Simpan</button>
                                <button type="button" class="btn btn-sm btn-warning font-weight-bold" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                            Dokumen memmbutuhkan lampiran pendukung atau tidak. Jika <b>"Ya"</b> maka ketika input dokumen wajib melampirkan dokumen pendukung lainnya, jika <b>"Tidak"</b> maka tidak perlu melampirkan dokumen pendukung.
                            </div>
                        </div>
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

        $("form#formAddSubKategori").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('kasKategori')}}/addSubKategori/postSubKategori",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    if (data.warning) {
                        alertify.error('data.warning');
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