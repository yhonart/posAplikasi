<div class="row p-1">
    <div class="col-12">
        <div class="card bg-danger animate__animated animate__flipInX">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Hapus Data</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible mb-2 border-0">
                  <h5><i class="icon fas fa-ban"></i> Alert!, Apakah anda yakin akan menghapus data transaksi {{$idTrx}}</h5>
                  Data akan terhapus dari transaksi dan no transaksi dapat digunakan kembali. Tekan <b>Ya</b> untuk menghapus, tekan <b>Tidak</b> untuk membatalkannya.
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-center">
                        <form class="form" id="formDeleteTrx">
                            <input type="hidden" name="idTrx" value="{{$idTrx}}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success pl-4 pr-4 pt-2 pb-2 elevation-2 font-weight-bold" id="btnYes"><i class="fa-solid fa-circle-check"></i> YA</button>
                                <button type="button" class="btn btn-sm btn-primary pl-4 pr-4 pt-2 pb-2 elevation-2 font-weight-bold" id="btnNo"><i class="fa-solid fa-circle-xmark"></i> TIDAK</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("form#formDeleteTrx").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('Cashier')}}/buttonAction/postDaleteData",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    window.location.reload();
                }
            });
            return false;
        });
        $("#btnNo").on('click', function(){
            window.location.reload();
        })
    });
</script>