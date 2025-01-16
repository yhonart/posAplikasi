<div class="card">
    <div class="card-body">
        <form id="formAddModalKas">
            <div class="form-group row">
                <label for="danaTambahan" class="label col-md-3">Nominal</label>
                <div class="col-md-4">
                    <input type="text" class="form-control priceText" name="nominal" id="nominal">
                </div>
            </div>
            <div class="form-group row">
                <label for="danaTambahan" class="label col-md-3">Sumber Dana</label>
                <div class="col-md-4">
                    <select name="sumberDana" id="sumberDana" class="from-control">
                        <option value="0"></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="danaTambahan" class="label col-md-3">Selisih</label>
                <div class="col-md-4">
                    <input type="text" class="form-control priceText" name="nominal" id="nominal">
                </div>
            </div>
            <div class="form-group row">
                <label for="danaTambahan" class="label col-md-3">Keterangan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nominal" id="nominal">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success" id="submitTambahModal">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $('.priceText').mask('000.000.000', {
            reverse: true
        });
    })
</script>