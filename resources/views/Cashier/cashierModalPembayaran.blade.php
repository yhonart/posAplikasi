<?php
    if($countKredit=='0'){
        $nominalKredit = "0";
    }
    else{
        $nominalKredit = $cekKredit->nom_kredit;
    }
?>
<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">{{$dataBilling->customer_name}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <p style="display:none;">'dataBilling','noBill','paymentMethod','tBayar','tBill'</p>
                <form id="formPembayaran">
                    <input type="hidden" name="billPembayaran" id="billPembayaran" value="{{$noBill}}">
                    <input type="hidden" name="memberID" id="memberID" value="{{$dataBilling->member_id}}">
                    <div class="form-group row mb-1 d-flex align-items-center">
                        <label class="col-4 text-right">GRAND TOTAL</label>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-lg form-control-border border-width-2 font-weight-bold" name="tBelanja" id="tBelanja" value="{{$totalBayar->totalBilling}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1 d-flex align-items-center">
                        <label class="col-4 text-right">HUTANG SEBELUMNYA</label>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-lg form-control-border border-width-2" name="kredit" id="kredit" value="{{$nominalKredit}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1 d-flex align-items-center">
                        <label class="col-4 text-right">TOTAL YANG HARUS DIBAYAR</label>
                        <div class="col-8">
                            <?php
                                $tPlusKredit = $totalBayar->totalBilling+$nominalKredit
                            ?>
                            <input type="text" class="form-control form-control-lg form-control-border border-width-2 font-weight-bold" name="tPlusKredit" id="tPlusKredit" value="{{$tPlusKredit}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1 d-flex align-items-center">
                        <label class="col-4 text-right">BAYAR</label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="tPembayaran" id="tPembayaran" value="">
                        </div>
                    </div>
                    <div class="form-group row mb-1 d-flex align-items-center">
                        <label class="col-4 text-right">METODE PEMBAYARAN</label>
                        <div class="col-8">
                            <select name="metodePembayaran" id="metodePembayaran" class="form-control">
                                @foreach($paymentMethod as $pM)
                                    <option value="{{$pM->idm_payment_method}}">
                                        {{$pM->method_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group mb-1" id="divBankAccount">
                        <label class="col-4"></label>
                        <div class="col-8">
                            <select name="bankAccount" id="bankAccount" class="form-control" style="display:none;">
                                <option value="0"></option>
                                @foreach($bankAccount as $bA)
                                    <option value="{{$bA->idm_payment}}">
                                        {{$bA->bank_name}} - {{$bA->account_number}} a.n {{$bA->account_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-1 row">
                        <label class="col-4"></label>
                        <div class="col-8">
                            <input type="text" name="cardName" id="cardName" class="form-control" placeholder="Nama Bank" style="display:none;">
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label class="col-4"></label>
                        <div class="col-8">
                            <input type="text" name="cardNumber" id="cardNumber" class="form-control" placeholder="Nomor Kartu" style="display:none;">
                        </div>
                    </div>
                    @include('Global.global_spinner')
                    <div class="form-group row mb-1 d-flex align-items-center">
                        <label class="col-4 text-right">KEMBALI/KREDIT</label>
                        <div class="col-8">
                            <input type="text" class="form-control border border-4 border-dange" name="nomSelisih" id="nomSelisih" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row align-items-cente">
                        <label class="col-4 text-right">Pengiriman</label>
                        <div class="col-8">
                            <select name="pengiriman" id="pengiriman" class="form-control form-control-sm ">
                                @foreach($pengiriman as $delv)
                                    <option value="{{$delv->delivery_name}}">
                                        {{$delv->delivery_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="ppn2" class="form-label col-4 text-right">PPN</label>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="ppn2" id="ppn2">
                                    <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                                </div>
                            </div>            
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm" name="nominalPPN2" id="nominalPPN2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <a class="btn bg-success p-3 elevation-2 font-weight-bold" id="btnSimpanTrx">
                                [Ctrl+S] Simpan & Cetak Struk
                            </a>
                            <a class="btn bg-primary p-3 elevation-2 font-weight-bold" data-dismiss="modal">
                                [ESC] Tutup Pembayaran
                            </a>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        
        $("#metodePembayaran").change(function(){
            let findMethod = $(this).find(":selected").val();
            if (findMethod === '4'){
                $("#cardName").fadeOut('slow');
                $("#cardNumber").fadeOut('slow');
                $("#bankAccount").fadeIn('slow');
            }
            else if (findMethod === '6'){
                $("#bankAccount").fadeOut('slow');
                $("#cardName").fadeIn('slow');
                $("#cardNumber").fadeIn('slow');
            }
            else{
                $("#bankAccount").hide();
                $("#cardName").hide();
                $("#cardNumber").hide();
            }
        })
    
        $("#tPembayaran").focus();
        $("#tBelanja").mask('000.000.000', {reverse: true});
        $("#tPembayaran").mask('000.000.000', {reverse: true});
        $("#nomSelisih").mask('000.000.000', {reverse: true});
        $("#kredit").mask('000.000.000', {reverse: true});
        $("#tPlusKredit").mask('000.000.000', {reverse: true});
        
        $("#tPlusKredit").on('input', computeBayar);
        $("#tPembayaran").on('input', computeBayar);
        $("#nomSelisih").on('input', computeBayar);
        $("#ppn2").on('input', computeBayar);
        
        function computeBayar(){
            let valBayar = "{{$tBayar}}",
                valBelanja = $("#tPlusKredit").val(),
                valPembayaran = $("#tPembayaran").val(),
                valPPN2 = $("#ppn2").val(),
                
                inputBelanja = valBelanja.replace(/\./g, ""),
                inputPembayaran = valPembayaran.replace(/\./g, "");
                
            if (typeof inputPembayaran == "undefined" || typeof inputPembayaran == "0") {
                return
            }
            
            let ppn = $("#ppn").val(),
                percBilling = parseInt(inputBelanja) * (valPPN2 / 100),
                totalPaymentDisplay = (parseInt(inputBelanja) + parseInt(percBilling));
            
            
            $("#nominalPPN2").val(accounting.formatMoney(percBilling,{
                symbol: "",
                precision: 0,
    	        thousand: ".",
            }));
    
            $("#tPlusKredit").val(accounting.formatMoney(totalPaymentDisplay,{
                symbol: "",
                precision: 0,
    	        thousand: ".",
            }));
            
            $("#nomSelisih").val(accounting.formatMoney(parseInt(inputPembayaran) - parseInt(totalPaymentDisplay),{
                symbol: "",
                precision: 0,
    	        thousand: ".",
            }));
        }
        $(".closePembayaran").on('click', function(){
            window.location.reload();
        });
        
        let billPembayaran = "{{$noBill}}";
        
        
        document.addEventListener('keydown', function(event) {
            
            if (event.ctrlKey && event.key === 's') { // Cetak
                event.preventDefault();
                let urlPrint = "{{route('Cashier')}}/buttonAction/printTemplateCashier/"+billPembayaran;
                let data_form = new FormData(document.getElementById("formPembayaran"));
                $(".LOAD-SPINNER").fadeIn('slow');
                $.ajax({
                    url: "{{route('Cashier')}}/buttonAction/postDataPembayaran",
                    type: 'post',
                    data: data_form,
                    async: true,
                    cache: true,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $(".LOAD-SPINNER").fadeOut('slow');
                        window.open(urlPrint,'_blank');
                        window.location.reload();
                    }
                });
            }
            
            if (event.keyCode === 27) {
                event.preventDefault();
                window.location.reload();
            }  
        });
        
        function searchData(keyWord, infoCode){        
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPelunasan/funcData/"+keyWord+"/"+infoCode,
                success : function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    $("#divDataPelunasan").html(response);
                }
            });
        }
    });
</script>