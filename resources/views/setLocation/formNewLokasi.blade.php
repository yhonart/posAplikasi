<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Tambah Lokasi Toko/Gudang
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form id="formNewLokasiToko">
                    <div class="form-group row">
                        <label for="kodeLokasi" class="col-md-4 text-right">Kode Lokasi</label>
                        <div class="col-md-4">
                            <input type="text" name="kodeLokasi" id="kodeLokasi" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="namaLokasi" class="col-md-4 text-right">Nama Lokasi</label>
                        <div class="col-md-4">
                            <input type="text" name="namaLokasi" id="namaLokasi" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-md-4 text-right">Alamat Lokasi</label>
                        <div class="col-md-4">
                            <input type="text" name="address" id="address" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="city" class="col-md-4 text-right">Kota</label>
                        <div class="col-md-4">
                            <input type="text" name="city" id="city" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="groupLoc" class="col-md-4 text-right">Group Lokasi</label>
                        <div class="col-md-4">
                            <select name="gropuLoc" id="groupLoc" class="form-control form-control-sm">
                                <option value="3">Toko</option>
                                <option value="4">Gudang</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success" id="btnSimpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>