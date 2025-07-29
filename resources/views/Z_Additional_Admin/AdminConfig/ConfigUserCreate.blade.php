<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Tambah Akun</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form id="formCreateAkun">

            <div class="form-group row">
                <label for="" class="col-md-4">Nama</label>
                <div class="col-md-4">
                    <input type="text" name="nama" id="nama" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Username</label>
                <div class="col-md-4">
                    <input type="text" name="username" id="username" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Password</label>
                <div class="col-md-4">
                    <input type="text" name="password" id="password" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Hak Akses</label>
                <div class="col-md-4">
                    <select name="hakAkses" id="hakAkses" class="form-control form-control-sm">
                        <option value="2">Kasir</option>
                        <option value="1">Admin</option>
                        <option value="3">Sales</option>
                        <option value="4">Admin Sales</option>
                        <option value="5">Kurir</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                <button type="submit" class="btn btn-sm btn-warning"><i class="fa-solid fa-xmark"></i> Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("form#formAddPersonalia").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('Personalia')}}/newUsers/postNewUser",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {     
                    $("form#formAddPersonalia")[0].reset();
                    $("#notive-display").fadeIn();
                },                
            });
            return false;
        });
    });
</script>