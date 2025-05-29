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
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success font-weight-bold" id="btnUpdateCompany">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>