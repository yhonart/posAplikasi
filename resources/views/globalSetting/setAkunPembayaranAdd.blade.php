<div class="card card-purple">
    <div class="card-header">
        <h3 class="card-title">Tambah Akun Pembayaran</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="card-body text-xs">
        <form id="formAddAkunPembayaran" autocomplete="off">
            <div class="form-group row">
                <label class="col-md-4">Kode Bank</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="kodeBank" id="kodeBank">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Nama Bank</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="namaBank" id="namaBank">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">No. Rek/Akun</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="noRek" id="noRek">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Nama Pemilik Akun</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="namaAkun" id="namaAkun">
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
        $("form#formAddAkunPembayaran").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('setPembayaran')}}/newAkunBank/postnewAkunBank",
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