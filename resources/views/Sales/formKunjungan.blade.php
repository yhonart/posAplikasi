<div class="row">
    <div class="col-md-12">
        <form id="inputFormKunjungan">
            <div class="form-group row">
                <label for="store" class="col-md-4">Nama Toko</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="store" id="store">
                </div>
            </div>
            <div class="form-group row">
                <label for="store" class="col-md-4">Nama Pemilik Toko</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="storeOwner" id="storeOwner">
                </div>
            </div>
            <div class="form-group row">
                <label for="store" class="col-md-4">No.Telefone Toko</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="phone" id="phone">
                </div>
            </div>
            <div class="form-group row">
                <label for="store" class="col-md-4">Progress</label>
                <div class="col-md-4">
                    <select name="progress" id="progress" class="form-control form-control-sm">
                        <option value="1">Penawaran</option>
                        <option value="2">Follow Up</option>
                        <option value="3">Deal</option>
                        <option value="4">No Deal</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="store" class="col-md-4">Tanggal Follow Up</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="dateFU" id="dateFU">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <button class="btn btn-sm btn-primary">Get Location</button>
            </div>
            <div class="form-group row">
                <label for="store" class="col-md-4">Latitude</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="Latitude" id="Latitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="store" class="col-md-4">Longitude</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="Longitude" id="Longitude">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label for="store" class="col-md-4">Foto Toko</label>
                <div class="col-md-4">
                    <input type="file" class="form-control form-control-sm" name="dateFU" id="dateFU">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success font-weight-bold" id="btnSaveKunjungan">Simpan</button>
            </div>
        </form>
    </div>
</div>