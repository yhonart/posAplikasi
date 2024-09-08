<div class="card card-purple">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Tambah Nominal Kas Untuk Kasir</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form id="formCreateKas">
                    <div class="form-group row">
                        <label class="col-md-4">Pilih User Kasir</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-sm rounded-0" name="selectPersonil" id="selectPersonil">
                                <option value="All">All Kasir</option>
                                @foreach($userKasir as $uk)
                                    <option value="{{$uk->id}}">{{$uk->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Nominal Kas</label>
                        <div class="col-md-4">
                            <input class="form-control form-control-sm rounded-0" name="nominalKas" id="nominalKas">
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-sm btn-success btn-flat">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("form#formCreateKas").submit(function(event){
        event.preventDefault();
        $.ajax({
            url: "{{route('setKasKasir')}}/newNominal/postNewNominal",
            type: 'POST',
            data: new FormData(this),
            async: true,
            cache: true,
            contentType: false,
            processData: false,
            success: function (data) {                    
                window.location.reload();
            },                
        });
        return false;
    });
</script>