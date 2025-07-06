<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Atur Pengiriman</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="" class="col-md-4">Atur Berdasarkan Hari</label>
                            <div class="col-md-4">
                                <select name="delByDay" id="delByDay" class="form-control form-control-sm">
                                    <option value="0" readonly></option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-4">Atur Berdasarkan Frequency</label>
                            <div class="col-md-4">
                                <input type="number" class="form-control form-control-sm" name="frequency" id="frequency">
                            </div>
                            <div class="col-md-4">
                                <span>Hari</span>
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success btn-sm font-weight-bold">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body bg-gradient-info">
                            <p>
                                Form ini digunakan untuk mengatur jadwal pengiriman ke pelanggan.
                                Pilih salah satu metode pengiriman, menggunakan jadwal hari tertentu atau menggunakan
                                frequency berapa hari sekali dalam pengiriman.
                            </p>
                            <p>
                                Jika sudah dilakukan pengaturan ini maka kurir secara otomatis akan mendapatkan jadwal pengiriman. 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>