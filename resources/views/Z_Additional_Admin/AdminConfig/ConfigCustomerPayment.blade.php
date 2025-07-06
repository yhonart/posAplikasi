<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Atur Metode Pembayaran</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="" class="col-md-4">Metode Pembayaran Pelanggan</label>
                    <div class="col-md-4">
                        <select name="metodePembayaran" id="metodePembayaran" class="form-control form-control-sm">
                            <option value="{{$selectCustomer->payment_type}}">{{$selectCustomer->payment_type}}</option>
                            <option value="0" disabled>===Change===</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Tempo">Tempo</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-success font-weight-bold" id="btnSimpanPembayaran">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#btnSimpanPembayaran").on('click', function (event){
            let idCus = "{{$idCus}}",
                pembayaran = $("#metodePembayaran");
            $("#btnSimpanPembayaran").fadeOut();
            let dataFormPayment = {idCus : idCus, pembayaran : pembayaran};
            $.ajax({
                type : 'post',
                url : "{{route('sales')}}/configCustomer/postConfigPembayaran",
                data :  dataFormPayment,
                success : function(data){                    
                    alertify.success('Data Berhasil Tersimpan');
                    $("#btnSimpanPembayaran").fadeIn();
                }
            });

        });
    });
</script>