<div class="card card-body">
    <div class="row">
        <div class="col-12">
            <form id="formPayMethod">
                <input type="hidden" name="idKredit" value="{{$datPayment->idp_kredit}}">
                <input type="hidden" name="idKredit" value="{{$datPayment->idp_kredit}}">
                <div class="form-group row">
                    <label class="col-md-2">AP Number</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="apNumber" id="apNumber" value="{{$numberTrx}}" readonly>
                    </div>
                    <label class="col-md-2">Purchase Number</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control form-control-sm" name="purchaseNumber" id="purchaseNumber" value="{{$datPayment->number_dok}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Saldo Hutang</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag" name="nominalKredit" id="nominalKredit" value="{{$datPayment->selisih}}" readonly>
                    </div>
                    <label class="col-md-2">Total Pembayaran</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag" name="nominalPayed" id="nominalPayed" value="{{$datPayment->payed}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Nominal Bayar</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag" name="nominal" id="nominal">
                    </div>
                    <label class="col-md-2">Selisih</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="selisih" id="selisih" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Metode Pembayaran</label>
                    <div class="col-md-3">
                        <select class="form-control form-control-sm" name="method" id="method">
                            <option value="TUNAI">TUNAI</option>
                            <option value="TRANSFER">TRANSFER</option>
                        </select>
                    </div>
                    <label class="col-md-2">Akun Pembayaran <small class="text-muted">[Optional]</small></label>
                    <div class="col-md-3">
                        <select class="form-control form-control-sm" name="account" id="account">
                            <option value="">....</option>
                            <option value="BANK">BANK</option>
                            <option value="CEK">CEK</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Nama Akun Bank <small class="text-muted">[Optional]</small></label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="accountName" id="accountName" placeholder="Jika menggunnakan selain tunai">
                    </div>
                    <label class="col-md-2">Nomor Akun Bank <small class="text-muted">[Optional]</small></label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="accountNumber" id="accountNumber" placeholder="Jika menggunnakan selain tunai">
                    </div>
                </div>
                <div class="form-group row">                    
                    <label for="description" class="col-md-2">Keterangan <small>[Optional]</small></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="description" id="description">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-sm elevation-2 font-weight-bold btn-block" id="submitPembayaran"><i class="fa-solid fa-receipt"></i> Bayar</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm elevation-2 font-weight-bold btn-block" id="batalPembayaran"><i class="fa-solid fa-circle-xmark"></i> Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    $(document).ready(function(){
        $('#nominalKredit').mask('000.000.000', {reverse: true});
        $('#nominal').mask('000.000.000', {reverse: true});

        $("#nominal").on('input', computBayar);

        function computBayar(){
            let nominalKredit = $("#nominalKredit").val(),
                nominal = $("#nominal").val();

            let replaceKredit = nominalKredit.replace(/\./g, ""),
                replaceNominal = nominal.replace(/\./g, "");

            if (typeof replaceNominal === "undefined" || typeof replaceNominal === "0") {
                return
            }
            let selisih = (parseInt(replaceKredit) - parseInt(replaceNominal));
            $("#selisih").val(accounting.formatMoney(selisih,{
                symbol: "",
                precision: 0,
    	        thousand: ".",
            }));
        }
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
        $("#batalPembayaran").on('click', function(e){
            e.preventDefault();
            window.location.reload();
        })
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