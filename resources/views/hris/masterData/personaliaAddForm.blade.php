<div class="row">
    <div class="col-12">
        <form id="formAddPersonalia">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm " name="namaLengkap" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control form-control-sm " name="userName" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control form-control-sm " name="password" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control form-control-sm " name="email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Set Lokasi Kerja</label>
                        <select class="form-control form-control-sm " name="lokasi">
                            <option value="0" readonly>Pilih Lokasi Kerja</option>
                            @foreach($mSite as $mS)
                                <option value="{{$mS->idm_site}}">{{$mS->site_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Set. Hak Akses User</label>
                        <select class="form-control form-control-sm " name="hakAkses">
                            <option value="2">Kasir</option>
                            <option value="1">Admin</option>
                            <option value="3">Sales</option>
                            <option value="4">Admin Sales</option>
                            <option value="5">Kurir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Level Admin</label>
                        <select class="form-control form-control-sm " name="levelAdmin">
                            <option value="0" readonly></option>
                            <option value="1">Super Admin</option>
                            <option value="2">Admin Spv.</option>
                            <option value="3">Admin Staff</option>
                        </select>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-block btn-sm font-weight-bold p-2 "><i class="fa-solid fa-floppy-disk"></i> SIMPAN</button>
                </div>
                <div class="col-md-6">
                    <span id="notive-display" style="display:none;">Data Berhasil Dimasukkan</span>
                </div>
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