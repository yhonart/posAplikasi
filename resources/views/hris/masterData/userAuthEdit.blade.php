<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Edit Hak Akses User</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body text-xs">
                <div id="loadDataHakAkses"></div>
                @if($countArea == '0')
                <form id="formEditProfile">
                    <input type="hidden" name="userID" value="{{$id}}">
                    <div class="form-group row">
                        <div class="col-12 col-md-4">
                            <label class="label">User Area</label>
                            <select name="userArea" class="form-control form-control-sm form-control-border">
                                <option value="0" readonly>Pilih</option>
                                @foreach($userArea as $uA)
                                    <option value="{{$uA->idm_site}}">{{$uA->site_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="label">Hak Akses</label>
                            <select name="userHakAkses" class="form-control form-control-sm form-control-border">
                                <option value="0" readonly>Pilih</option>
                                <option value="1">Admin</option>
                                <option value="2">Kasir</option>
                                <option value="3">Sales</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="label">Admin Group</label>
                            <select name="userHakAkses" class="form-control form-control-sm form-control-border">
                                <option value="0" readonly>Pilih</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Admin Spv.</option>
                                <option value="3">Admin Staff</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
                @endif
                <hr>
                @if($superUser->role_code == '1')
                <p>User memiliki hak akses Super User/Administrator</p>
                @elseif(empty($superUser))
                <p>User tidak memiliki hak akses admin !</p>
                @else
                <h5 class="font-weight-bold text-muted">Konfigurasi hak akses menu</h5>
                <form id="createHakAksesMenu">
                    <input type="hidden" name="userID" value="{{$id}}">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <select class="form-control form-control-sm " name="selectMenu" id="selectMenu">
                                <option value="0" readonly>Kategori Menu</option>
                                @foreach($selectSystem as $ss)
                                <option value="{{$ss->idm_system}}">{{$ss->system_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control form-control-sm " name="subMenu" id="subMenu">
                                <option value="0" readonly>Sub Menu</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-sm " id="submitAkses">Simpan</button>
                        </div>
                    </div>
                </form>
                <div id="loadHakAksesMenu"></div>
                @endif
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
        let id = "{{$id}}";
        $("#loadDataHakAkses").load("{{route('Personalia')}}/loadDataHakAkses",{id:id});
        $("#loadHakAksesMenu").load("{{route('Personalia')}}/loadHakAksesMenu/"+id);
        $("form#formEditAuth").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('Personalia')}}/postEditHakAkses",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    $("#loadDataHakAkses").load("{{route('Personalia')}}/loadDataHakAkses",{id:id});
                },                
            });
            return false;
        });
        
        $("#selectMenu").change(function(){
            let menuID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('Personalia')}}/subMenuList/" + menuID,
                success : function(response){  
                    $("#subMenu").html(response);
                }
            });
        })
        $("form#createHakAksesMenu").submit(function(event){
            event.preventDefault();
            $("#submitAkses").fadeOut();
            $.ajax({
                url: "{{route('Personalia')}}/postHakAksesMenu",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {  
                    $("#submitAkses").fadeIn();
                    $("#loadHakAksesMenu").load("{{route('Personalia')}}/loadHakAksesMenu/"+id);
                },                
            });
            return false;
        });
    });
</script>