<div class="card card-body">
    <div class="row">
        <div class="col-12">
            <form id="formPayMethod">
                <input type="hidden" name="idPayment" value="{{$datPayment->number_dok}}">
                <div class="form-group row">
                    <label class="col-4">AP Number</label>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm" name="purchaseNumber" id="purchaseNumber" value="{{$numberTrx}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4">Purchase Number</label>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm" name="purchaseNumber" id="purchaseNumber" value="{{$datPayment->number_dok}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4">Nominal Kredit</label>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm price-tag" name="nominalKredit" id="nominalKredit" value="{{$datPayment->kredit}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4">Nominal Bayar</label>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm price-tag" name="nominal" id="nominal" value="{{$tbPayment->kredit_pay}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4">Selisih</label>
                    <div class="col-6">
                        <?php
                            $selisih = $datPayment->kredit - $tbPayment->kredit_pay;
                        ?>
                        <input type="text" class="form-control form-control-sm" name="selisih" id="selisih" value="{{$selisih}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4">Metode Pembayaran</label>
                    <div class="col-6">
                        <select class="form-control form-control-sm" name="method" id="method">
                            <option value="TUNAI">TUNAI</option>
                            <option value="TRANSFER">TRANSFER</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4">Akun Pembayaran <small class="text-muted">[Optional]</small></label>
                    <div class="col-6">
                        <select class="form-control form-control-sm" name="account" id="account">
                            <option value="">....</option>
                            <option value="BANK">BANK</option>
                            <option value="CEK">CEK</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4">Nama Akun Bank <small class="text-muted">[Optional]</small></label>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm" name="accountName" id="accountName" placeholder="Jika menggunnakan selain tunai">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4">Nomor Akun Bank <small class="text-muted">[Optional]</small></label>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm" name="accountNumber" id="accountNumber" placeholder="Jika menggunnakan selain tunai">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success btn-sm elevation-2 font-weight-bold btn-block" id="submitPembayaran"><i class="fa-solid fa-receipt"></i> Bayar</button>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-danger btn-sm elevation-2 font-weight-bold btn-block" id="batalPembayaran"><i class="fa-solid fa-circle-xmark"></i> Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.price-tag').mask('000.000.000', {reverse: true});
        let datFilter = "dataPurchasing";
        $("form#formPayMethod").submit(function(event){
            $("#submitPembayaran").hide();
            event.preventDefault();
            $.ajax({
                url: "{{route('Purchasing')}}/Bayar/postModalPembayaran",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('body').removeClass('modal-open');
                    $("#modal-global-large").modal('hide');
                    $('.modal-backdrop').remove();
                    displayLoadFilter(datFilter);
                }
            });
            return false;
        });
    });
    
    function displayLoadFilter(datFilter){
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/"+datFilter,
            success : function(response){
                $("#divPageProduct").html(response);
            }
        });
    }
</script>