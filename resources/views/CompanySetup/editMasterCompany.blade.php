<?php
$arrayModule = array(
        "AM1"=>"FULL MENU",
        "AM2"=>"FULL MENU TANPA KAS",
        "AM3"=>"INVENTORY + KAS",
    );
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Edit Master Data Company</h3>
            </div>
            <div class="card-body text-xs">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formEditCompany">
                            <input type="hidden" name="hiddenID" id="hiddenID" value="{{$companyData->idm_company}}">
                            <div class="form-group row">
                                <label class="label col-md-4">Nama Perusahaan</label>
                                <div class="col-md-4">
                                    <input type="text" name="namaUsaha" id="namaUsaha" class="form-control form-control-sm" value="{{$companyData->company_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-md-4">Kode Usaha</label>
                                <div class="col-md-4">
                                    <input type="text" name="kodeUsaha" id="kodeUsaha" class="form-control form-control-sm" value="{{$companyData->company_code}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-md-4">Bidang Usaha</label>
                                <div class="col-md-4">
                                    <input type="text" name="bidangUsaha" id="bidangUsaha" class="form-control form-control-sm" value="{{$companyData->company_description}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-md-4">Alamat</label>
                                <div class="col-md-4">
                                    <input type="text" name="alamat" id="alamat" class="form-control form-control-sm" value="{{$companyData->address}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-md-4">Owner/Personal Paraf</label>
                                <div class="col-md-4">
                                    <input type="text" name="owner" id="owner" class="form-control form-control-sm" value="{{$companyData->owner}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-md-4">Telefone</label>
                                <div class="col-md-4">
                                    <input type="text" name="telefone" id="telefone" class="form-control form-control-sm" value="{{$companyData->telefone}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-md-4">Company APL Module</label>
                                <div class="col-md-2">
                                    <span class="font-weight-bold text-success">
                                        {{$arrayModule[$companyData->sys_module_code]}}
                                    </span>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-sm font-weight-bold" type="button" data-toggle="collapse" data-target="#changeModuleApl" aria-expanded="false" aria-controls="collapseExample">Change</button>
                                </div>
                                <div class="col-md-4">
                                    <div class="collapse" id="changeModuleApl">
                                        <select name="aplModule" id="aplModule" class="form-control form-control-sm">
                                            <option value="{{$companyData->sys_module_code}}" readonly></option>                                            
                                            <option value="AM1">FULL MENU</option>
                                            <option value="AM2">FULL MENU TANPA KAS</option>
                                            <option value="AM3">INVENTORY + KASIR</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success font-weight-bold" id="btnUpdateCompany">Simpan</button>
                                <button type="button" class="btn btn-sm btn-warning font-weight-bold" id="closeBtn">Batalkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#closeBtn').on('click', function (e) {
            e.preventDefault();
            window.location.reload();
        });
        $("form#formEditCompany").submit(function(event){
            event.preventDefault();
            $("#btnUpdateCompany").fadeOut();
            $.ajax({
                url : "{{route('CompanySetup')}}/companyDisplay/postEditCompany",
                type : 'POST',
                data : new FormData(this),
                async : true,
                cache : true,
                contentType : false,
                processData : false,
                success : function (data) {                    
                    window.location.reload();
                }
            })
        })
    });
</script>