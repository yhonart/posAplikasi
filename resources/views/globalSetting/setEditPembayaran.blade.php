<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Metode Pembayaran</h3>
    </div>
    <div class="card-body">
        <form id="formEditPembayaran">
            <input type="hidden" name="idMethod" value="{{$dbMstrMethod->idm_payment_method}}">
            <div class="form-group row">
                <label class="col-md-4">Metode Pembayaran</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm " name="mPembayaran" id="mPembayaran" value="{{$dbMstrMethod->method_name}}">
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
        $("form#formEditPembayaran").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('setPembayaran')}}/editMethod/postEditPembayaran",
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