<?php
    $utilityArray = array("Mobil", "Motor", "Handphone", "Lain-Lain");
?>
<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Edit Profile User {{$tbUser->name}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <form id="formEditProfile">
                    <input type="hidden" name="idUser" id="idUser" value="{{$id}}">
                    <div class="form-group row">
                        <label class="label col-2">Nama Lengkap</label>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm " name="namaLengkap" autocomplate="off" value="{{$tbUser->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-2">Username</label>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm " name="userName" autocomplate="off" value="{{$tbUser->username}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-2">Email</label>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm " name="email" autocomplate="off" value="{{$tbUser->email}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-2">Jenis Utility</label>
                        <div class="col-4">
                            
                            <select name="utility" id="utility" class="form-control form-control-sm">
                                <option value="{{$tbUser->utility}}">{{$tbUser->utility}}</option>
                                @foreach($utilityArray as $ua)
                                    @if($ua <> $tbUser->utility)
                                        <option value="{{$ua}}">{{$ua}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-2">Nomor Utility</label>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm " name="noUtility" autocomplate="off" value="{{$tbUser->no_utility}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-2">Company</label>
                        <div class="col-4">
                            <select name="companyID" id="companyID" class="form-control form-control-sm">
                                @if($hakAkses == '3')
                                    @foreach($mCompany as $c)
                                    <option value="{{$c->idm_company}}">{{$c->company_name}} - {{$c->location_name}}</option>
                                    @endforeach
                                @elseif(empty($userCompany) AND $hakAkses != '3')
                                    <option value="0" disabled>Disabled</option>
                                @else
                                    <option value="{{$userCompany->company}}" readonly>{{$userCompany->company_name}}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <button type="submit" class="btn btn-success btn-block btn-sm font-weight-bold">Simpan Profile</button>
                        </div>
                        <div class="col-8">
                            <span id="notive-display" style="display:none;">Data Berhasil Dimasukkan</span>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary mb-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Ganti Password
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <form id="formGantiPassword">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <button type="submit" class="btn bg-olive" id="changePassword">Simpan</button>
                              </div>
                              <input type="hidden" name="userID" id="userID" value="{{$id}}">
                              <input type="hidden" name="email" id="email" value="{{$tbUser->email}}">
                              <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </form>
                    </div>
                </div>
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
        let id = "{{$id}}",
            keyWord = '0';
        
        $("form#formEditProfile").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('Personalia')}}/formEditProfile",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    searchData(keyWord);
                },                
            });
            return false;
        });

        $("form#formGantiPassword").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('Personalia')}}/postChangePassword",
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
        
        // $("#changePassword").on('click', function(){
        //     alertify.error('Untuk merubah password belum dapat digunakan !');
        // });
        
        function searchData(keyWord){        
            $.ajax({
                type : 'get',
                url : "{{route('Personalia')}}/dataTablePersonalia/searchData/"+keyWord,
                success : function(response){
                    $(".DIV-SPIN").fadeOut();
                    $("#divListPersonalia").html(response);
                }
            });
        }
    });
</script>