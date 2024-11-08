<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Akun Pembayaran</h3>
    </div>
    <div class="card-body">
        <form id="formEditAkunBank">
            <input type="hidden" name="idAkun" id="idAkun" value="{{$id}}">
            <div class="form-group row">
                <label class="col-md-4">Kode Bank`</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="kodeBank" id="kodeBank" value="{{$tbEditAkun->bank_code}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Nama Bank</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="namaBank" id="namaBank" value="{{$tbEditAkun->bank_name}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">No. Rek/Akun</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="noRek" id="noRek" value="{{$tbEditAkun->account_number}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Nama Pemilik Akun</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="namaAkun" id="namaAkun" value="{{$tbEditAkun->account_name}}">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-sm  btn-success form-weight-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){        
        $("form#formEditAkunBank").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('setPembayaran')}}/postEditAkun",
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
    });
</script>