<div class="card card-body">
    <div class="row">
        <div class="col-12">
            <form id="formPayMethod">
                <input type="hidden" name="idKredit" value="{{$datPayment->idp_kredit}}">
                <input type="hidden" name="idKredit" value="{{$datPayment->idp_kredit}}">
                <div class="form-group row">
                    <label class="col-md-3">AP Number</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="apNumber" id="apNumber" value="{{$numberTrx}}" readonly>
                    </div>
                    <label class="col-md-3">Purchase Number</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="purchaseNumber" id="purchaseNumber" value="{{$datPayment->number_dok}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Saldo Hutang</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag" name="nominalKredit" id="nominalKredit" value="{{$datPayment->selisih}}" readonly>
                    </div>
                    <label class="col-md-3">Yang Telah Dibayar</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag" name="nominalPayed" id="nominalPayed" value="{{$datPayment->payed}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Nominal Bayar</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag" name="nominal" id="nominal" value="{{$datPayment->selisih}}">
                    </div>
                    <label class="col-md-3">Selisih</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="selisih" id="selisih" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Metode Pembayaran</label>
                    <div class="col-md-3">
                        <select class="form-control form-control-sm" name="method" id="method">
                            <option value="TUNAI">TUNAI</option>
                            <option value="TRANSFER">TRANSFER</option>
                        </select>
                    </div>
                    <label class="col-md-3">Akun Pembayaran <br><small class="text-muted">[Jika Menggunakan Transaksi Non Tunai]</small></label>
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
                    <label class="col-md-3">Nama Akun Bank <br><small class="text-muted">[Jika Menggunakan Transaksi Non Tunai]</small></label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="accountName" id="accountName" placeholder="Jika menggunnakan selain tunai">
                    </div>
                    <label class="col-md-3">Nomor Akun Bank<br><small class="text-muted">[Jika Menggunakan Transaksi Non Tunai]</small></label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="accountNumber" id="accountNumber" placeholder="Jika menggunnakan selain tunai">
                    </div>
                </div>
                <div class="from-group row">
                    <label class="col-md-3">Sumber Dana<br><small class="text-muted">[Berdasarkan Transaksi Perkasir Hari ini]</small></label>
                    <div class="col-md-3">
                        <select name="sumberDana" id="sumberDana" class="select2" multiple="multiple">
                            <option value="0"></option>
                            @foreach($sumberKas as $sk)
                            <option value="{{$sk->created_by}}|{{$sk->kasUmum}}">{{$sk->created_by}} - Rp.{{number_format($sk->kasUmum,'0',',','.')}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="displaySumberDana"></div>
                    </div>
                </div>
                <div class="form-group row">                    
                    <label for="description" class="col-md-3">Keterangan <small>[Optional]</small></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="description" id="description">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success btn-sm elevation-2 font-weight-bold btn-block" id="submitPembayaran"><i class="fa-solid fa-receipt"></i> Bayar</button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger btn-sm elevation-2 font-weight-bold btn-block" id="batalPembayaran"><i class="fa-solid fa-circle-xmark"></i> Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.select2').select2();
    })
    $(document).ready(function(){
        $('#nominalKredit').mask('000.000.000', {reverse: true});
        $('#nominal').mask('000.000.000', {reverse: true});
        $("#nominal").focus().select();
        $("#nominal").on('input', computBayar);
        computBayar();

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
                    window.location.reload();
                }
            });
            return false;
        });
        $("#batalPembayaran").on('click', function(e){
            e.preventDefault();
            window.location.reload();
        })
    });
</script>