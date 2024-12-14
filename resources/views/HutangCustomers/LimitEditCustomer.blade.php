<div class="card">
    <div class="card-header">
        <h3 class="text-title">Edit Limit Kredit Pelanggan</h3>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-md-4">Nama Toko/Pelanggan</dt>
            <dd class="col-md-4">{{$selectCustomer->customer_store}}</dd>
        </dl>
        <dl class="row">
            <dt class="col-md-4">Alamat</dt>
            <dd class="col-md-4">{{$selectCustomer->city}}. {{$selectCustomer->address}}</dd>
        </dl>
        <dl class="row">
            <dt class="col-md-4">Tipe Pelanggan</dt>
            <dd class="col-md-4">{{$selectCustomer->customer_type}}</dd>
        </dl>
        <form id="formEditLimit">
            <input type="hidden" name="idCus" id="idCus" value="{{$selectCustomer->idm_customer}}">
            <dl class="row">
                <dt class="col-md-4">Kredit Limit</dt>
                <dd class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="kreditLimit" id="kreditLimit" value="{{$selectCustomer->kredit_limit}}">
                </dd>
            </dl>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success btn-sm" id="btnEditLimit">Simpan</button>
                    <button type="button" class="btn btn-warning btn-sm" id="btnCloseModal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>