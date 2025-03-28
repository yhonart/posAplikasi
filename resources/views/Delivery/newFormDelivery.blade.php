<div class="card card-body text-xs">
    <form class="form" id="formDelivery">
        <div class="form-group row">
            <label class="col-md-4">Kode/Akun Delivery</label>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-sm" name="codeDelivery" id="codeDelivery" autocomplate="off">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Nama</label>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-sm" name="nameDelivery" id="nameDelivery" autocomplate="off">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4">Keterangan</label>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan" autocomplate="off">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-md btn-success elevation-2"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    $(document).ready(function(){  
        $("form#formDelivery").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('Delivery')}}/formEntryDelivery/postDataDelivery",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    if (data.warning){
                        alertify
                          .alert(data.warning, function(){
                            alertify.message('Gagal Input Data!');
                          }).set({title:"WARNING !"});
                    }
                    else if (data.success)
                    {   
                        alertify.success(data.success);
                        window.location.reload();
                    }
                }
            });
            return false;
        }); 
    }); 
</script>