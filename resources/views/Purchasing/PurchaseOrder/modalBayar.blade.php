<div class="card card-body">
    <div class="row">
        <div class="col-12">
            <form id="formPayMethod">
                <input type="hidden" name="idKredit" value="{{$datPayment->idp_kredit}}">
                <input type="hidden" name="idKredit" value="{{$datPayment->idp_kredit}}">
                <div class="from-group row">
                    <label class="col-md-3">Supplier</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm font-weight-bold" name="supplier" id="supplier" value="{{$datPayment->store_name}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">AP Number</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm font-weight-bold" name="apNumber" id="apNumber" value="{{$numberTrx}}" readonly>
                    </div>
                    <label class="col-md-3">Purchase Number</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm font-weight-bold" name="purchaseNumber" id="purchaseNumber" value="{{$datPayment->number_dok}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Saldo Hutang</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag font-weight-bold" name="nominalKredit" id="nominalKredit" value="{{$datPayment->selisih}}" readonly>
                    </div>
                    <label class="col-md-3">Yang Telah Dibayar</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag font-weight-bold" name="nominalPayed" id="nominalPayed" value="{{$datPayment->payed}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3">Nominal Bayar</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm price-tag text-success font-weight-bold" name="nominal" id="nominal" value="{{$datPayment->selisih}}">
                    </div>
                    <label class="col-md-3">Selisih</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm text-info font-weight-bold" name="selisih" id="selisih" readonly>
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
                    <label class="col-md-3">Akun Pembayaran</label>
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
                    <label class="col-md-3">Nama Akun Bank</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="accountName" id="accountName" placeholder="Jika menggunnakan selain tunai">
                    </div>
                    <label class="col-md-3">Nomor Akun Bank</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="accountNumber" id="accountNumber" placeholder="Jika menggunnakan selain tunai">
                    </div>
                </div>
                <hr>
                <div class="from-group row">
                    <label class="col-md-3">Sumber Dana<br><small class="text-muted">[Berdasarkan Transaksi Perkasir Hari ini]</small></label>
                    <div class="col-md-3">
                        <select name="sumberDana" id="sumberDana" class="form-control form-control-sm">
                            <option value="0"></option>
                            @foreach($sumberKas as $sk)
                            <option value="{{$sk->created_by}}">{{$sk->created_by}} - Rp.{{number_format($sk->kasUmum,'0',',','.')}}</option>
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
        $('.select2').select2({
            theme: 'bootstrap4'
        });        
    })
    $(document).ready(function(){
        $('#nominalKredit').mask('000.000.000', {reverse: true});
        $('#nominal').mask('000.000.000', {reverse: true});
        $("#nominal").focus().select();
        $("#nominal").on('input', computBayar);
        
        computBayar();
        
        let kasir = '0',
            apNumber = $("#apNumber").val(),
            nominal = $("#nominal").val(),
            purchaseNumber = $("#purchaseNumber").val();
        tampilSumberDana (kasir,apNumber,purchaseNumber);

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

        $("#sumberDana").change(function(){
            let kasir = $(this).val(),
                apNumber = $("#apNumber").val(),
                nominal = $("#nominal").val(),
                purchaseNumber = $("#purchaseNumber").val();
            // alert (kasir);
            $.ajax({
                type : 'post',
                url : "{{route('Purchasing')}}/Bayar/postSumberDana",
                data : {kasir:kasir,apNumber:apNumber,purchaseNumber:purchaseNumber,nominal:nominal},
                success : function(data){
                    tampilSumberDana (kasir,apNumber,purchaseNumber);
                }
            });
        });

        function tampilSumberDana (kasir,apNumber,purchaseNumber){            
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/Bayar/getDisplaySumberDana/"+kasir+"/"+apNumber+"/"+purchaseNumber,
                success : function(response){
                    $("#displaySumberDana").html(response);
                }
            });
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