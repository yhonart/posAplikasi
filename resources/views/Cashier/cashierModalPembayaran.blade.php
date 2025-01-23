<?php
    if($countKredit=='0'){
        $nominalKredit = "0";
    }
    else{
        $nominalKredit = $cekKredit->kredit;
    }
?>
<?php
    $nominal = "0";
    foreach($cekPayMethod as $cekPay){
        $nominal += $cekPay->nominal;
    }
    $nilaiNextBayar = (int)$totalBayar->totalBilling - (int)$nominal;
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
                <div class="row mb-1">
                    <div class="col-md-12">
                        <p class="notive-display bg-danger p-2 rounded rounded-2 elevation-2 font-weight-bold" id="notiveDisplay" style="display:none;"></p>
                    </div>
                </div>                
                <!--<p class="bg-danger p-4">PROSES PEMBAYARAN SEDANG DALAM PERBAIKAN, MOHON UNTUK TIDAK MELAKUKAN TRANSAKSI !</p>-->
                <div class="row">
                    <div class="col-md-12">
                        <p style="display:none;">'dataBilling','noBill','paymentMethod','tBayar','tBill'</p>
                        <h1 class="bg-light p-4 elevation-1"><small>Total Belanja </small><span class="float-right"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($totalBayar->totalBilling,0,',','.')}}</span></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form id="formPembayaran">
                            <input type="hidden" name="billPembayaran" id="billPembayaran" value="{{$noBill}}">
                            <input type="hidden" name="memberID" id="memberID" value="{{$dataBilling->member_id}}">
                            <input type="hidden" name="record" id="record" value="{{$cekRecord}}">
                            <input type="hidden" name="cusName" id="cusName" value="{{$dataBilling->customer_name}}">
                            <input type="hidden" name="tItem" id="tItem" value="{{$dataBilling->customer_name}}">
                            @if($cekRecord=='0')
                                <input type="hidden" name="lastBayar" id="lastBayar" value="0">
                            @else
                                <input type="hidden" name="lastBayar" id="lastBayar" value="{{$cekTotalBayar->total_struk}}">
                            @endif
                            <input type="hidden" name="tBelanja" id="tBelanja" value="{{$totalBayar->totalBilling}}">
                            
                            <div class="form-group row mb-1 d-flex align-items-center">
                                <label class="col-md-4 text-right">HUTANG SEBELUMNYA</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control form-control-lg font-weight-bold" name="kredit" id="kredit" value="{{$nominalKredit}}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="lunasiHutang" name="lunasiHutang" value="1">
                                        <label for="lunasiHutang" class="form-check-label">Lunasi Hutang</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-1 d-flex align-items-center">
                                <label class="col-md-4 text-right">TOTAL YANG HARUS DIBAYAR</label>
                                <div class="col-md-4">
                                    <?php
                                        $tPlusKredit = $totalBayar->totalBilling+$nominalKredit
                                    ?>
                                    <input type="text" class="form-control form-control-lg  font-weight-bold" name="tPlusKredit" id="tPlusKredit" value="{{$tPlusKredit}}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-default btn-sm copy_nominal" id="copyButton" data-id="{{$tPlusKredit}}"><i class="fa-solid fa-copy"></i> Copy Nominal</button>
                                </div>
                            </div>
                            <div class="form-group row mb-1 d-flex align-items-center" id="bayar1">
                                <label class="col-md-4 text-right">BAYAR</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control form-control-lg  font-weight-bold" name="tPembayaran" id="tPembayaran" value="{{$totalBayar->totalBilling}}" autocomplete="off" onClick="this.select();">
                                </div>
                            </div>
                            <div class="form-group row mb-1 d-flex align-items-center" id="bayar1">
                                <label class="col-md-4 text-right">POINT BELANJA</label>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <?php
                                            if ($pointMember->point <> '') {
                                                $pointPlg = $pointMember->point;
                                            }
                                            else {
                                                $pointPlg = '0';                                        
                                            }
                                        ?>
                                        <input class="custom-control-input" type="checkbox" id="pointBelanja" name="pointBelanja" value="{{$pointPlg}}" onclick="myFunctionAddPoint()">
                                        <label for="pointBelanja" class="custom-control-label text-muted">Point yang bisa digunakan : Rp. {{$pointPlg}},-</label>
                                        
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row mb-1 d-flex align-items-center" id="divMethod1">
                                <label class="col-md-4 text-right">METODE PEMBAYARAN</label>
                                <div class="col-md-4">
                                    <select name="metodePembayaran1" id="metodePembayaran1" class="form-control ">
                                        @foreach($paymentMethod as $pM)
                                            <option value="{{$pM->idm_payment_method}}|{{$pM->method_name}}">
                                                {{$pM->method_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="cardName1" id="cardName1" class="form-control " placeholder="Nama Bank" style="display:none;">
                                    <input type="text" name="cardNumber1" id="cardNumber1" class="form-control " placeholder="Nomor Kartu" style="display:none;">
                                    <select name="bankAccount1" id="bankAccount1" class="form-control " style="display:none;">
                                        <option value="0|0">NAMA BANK</option>
                                        @foreach($bankAccount as $bA)
                                            <option value="{{$bA->idm_payment}}|{{$bA->bank_name}}">
                                                {{$bA->bank_name}} - {{$bA->account_number}} a.n {{$bA->account_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-danger">! Abaikan jika  menggunakan 2 metode pembayaran / pembayaran 0 atau kredit</small>
                                </div>
                            </div>
                            @include('Global.global_spinner')
                            <div class="form-group row mb-1 d-flex align-items-center">
                                <label class="col-4 text-right">KEMBALI/KREDIT</label>
                                <div class="col-4">
                                    <input type="text" class="form-control border border-4 border-danger " name="nomSelisih" id="nomSelisih" value="0" readonly>
                                </div>
                            </div>
                            <div class="form-group row align-items-cente">
                                <label class="col-4 text-right">PENGIRIMAN</label>
                                <div class="col-4">
                                    <select name="pengiriman" id="pengiriman" class="form-control ">
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
                                        <input type="text" class="form-control " name="ppn2" id="ppn2">
                                            <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                                        </div>
                                    </div>            
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control " name="nominalPPN2" id="nominalPPN2">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12"> 
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="radioMethod" id="radioMethod" value="1" onclick="myFunctionChecked()">
                                        <label class="form-check-label font-weight-bold">Metode Pembayaran Lebih Dari 1 Pembayaran</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-sm table-borderless" id="tableMethod" style="display:none;">
                                        <tbody id="recordMethod"></tbody>
                                        <tbody>
                                            <tr>
                                                <td class="text-right font-weight-bold">Metode Pembayaran</td>
                                                <td>
                                                    <select name="metodePembayaran" id="metodePembayaran" class="form-control ">
                                                        @foreach($paymentMethod as $pM)
                                                            <option value="{{$pM->idm_payment_method}}">
                                                                {{$pM->method_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control type-account " name="nominalBayar" id="nominalBayar" autocomplete="off">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info " id="addPaymentMethod"><i class="fas fa-plus"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <select name="bankAccount" id="bankAccount" class="form-control " style="display:none;">
                                                        <option value="0"></option>
                                                        @foreach($bankAccount as $bA)
                                                            <option value="{{$bA->idm_payment}}">
                                                                {{$bA->bank_name}} - {{$bA->account_number}} a.n {{$bA->account_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input type="text" name="cardName" id="cardName" class="form-control " placeholder="Nama Bank" style="display:none;">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input type="text" name="cardNumber" id="cardNumber" class="form-control " placeholder="Nomor Kartu" style="display:none;">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <div class="from-group">
                                        <select name="typeCetak" id="typeCetak" class="form-control ">
                                            <option value="1">Cetak Struk</option>
                                            <option value="2">Cetak Faktur</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-md-3">
                                    <a class="btn bg-success font-weight-bold btn-block" id="btnSimpanTrx">
                                        [Ctrl+S] Simpan & Cetak
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn bg-primary font-weight-bold btn-block" id="btnBatalTrx" data-dismiss="modal">
                                        [ESC] Tutup Pembayaran
                                    </a>  
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <p id="notif-error"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(function () {
        let billNumber = "{{$noBill}}";
        $("#recordMethod").load("{{route('Cashier')}}/buttonAction/loadDataMethod/"+billNumber);
        $("#tPembayaran").focus().select();
        
    });

    $(document).on('click','.copy_nominal',function(e){
        e.preventDefault();
        let timer = null;
        let el_this = $(this);
        let textToCopy = $(this).attr('data-id');
        // navigator clipboard api needs a secure context (https)
        if (navigator.clipboard && window.isSecureContext) {
            // navigator clipboard api method'
            el_this.html("Copied! " + textToCopy);
            $("#tPembayaran").val(accounting.formatMoney(parseInt(textToCopy),{
                symbol: "",
                precision: 0,
    	        thousand: ".",
            }));
            timer = setTimeout(function(){el_this.html('<i class="far fa-copy"></i> Copied! ' + textToCopy);}, 500);            
            return navigator.clipboard.writeText(textToCopy);
        } else {
            // text area method
            let textArea = document.createElement("textarea");
            textArea.value = textToCopy;
            // make the textarea out of viewport
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            el_this.html("Copied!");
            $("#tPembayaran").val(accounting.formatMoney(parseInt(textToCopy),{
                symbol: "",
                precision: 0,
    	        thousand: ".",
            }));
            timer = setTimeout(function(){el_this.html('<i class="far fa-copy"></i>' + textToCopy);}, 500);

            return new Promise((res, rej) => {
                // here the magic happens
                document.execCommand('copy') ? res() : rej();
                textArea.remove();
            });
        }
    })

    // function copyFunction() {
    //     // Get the text field
    //     var copyText = document.getElementById("tPlusKredit");
    //     copyText.select();
    //     copyText.setSelectionRange(0, 99999);
    //     navigator.clipboard.writeText(copyText.value);
    //     alert("Copied Nominal: " + copyText.value);
    // }
    
    function myFunctionAddPoint() {
        var checkBox = document.getElementById("pointBelanja");
        var valCheckBox = $("#pointBelanja").val();
        var tBayar = $("#tPembayaran").val();
        var hitPoint = tBayar.replace(/\./g, "");
        var bayar = "{{$totalBayar->totalBilling}}";
        if (checkBox.checked == true){
            $("#tPembayaran").val(accounting.formatMoney(parseInt(hitPoint) - parseInt(valCheckBox),{
                symbol: "",
                precision: 0,
    	        thousand: ".",
            }));
        }
        else{
            $("#tPembayaran").val(accounting.formatMoney(parseInt(bayar),{
                symbol: "",
                precision: 0,
    	        thousand: ".",
            }));
        }
    }
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
        $("#metodePembayaran1").change(function(){
            let findMethod = $(this).find(":selected").val();
            if (findMethod === '4'){
                $("#cardName1").fadeOut('slow');
                $("#cardNumber1").fadeOut('slow');
                $("#bankAccount1").fadeIn('slow');
            }
            else if (findMethod === '6'){
                $("#bankAccount1").fadeOut('slow');
                $("#cardName1").fadeIn('slow');
                $("#cardNumber1").fadeIn('slow');
            }
            else{
                $("#bankAccount1").hide();
                $("#cardName1").hide();
                $("#cardNumber1").hide();
            }
        })
        $("#addPaymentMethod").on('click', function(){
            let methodName = $("#metodePembayaran").find(":selected").val(),
                postNominal = $("#nominalBayar").val(),
                cardName = $("#cardName").val(),
                cardNumber = $("#cardNumber").val(),
                bankAccount = $("#bankAccount").val(),
                billNumber = "{{$noBill}}",
                totalBelanja = $("#tBelanja").val();

            $.ajax({
                url: "{{route('Cashier')}}/buttonAction/postDataMethodPembayaran",
                type: 'post',
                data: {methodName:methodName,postNominal:postNominal,cardName:cardName,cardNumber:cardNumber,bankAccount:bankAccount,billNumber:billNumber,totalBelanja:totalBelanja},
                success: function (data) {
                    $("#recordMethod").load("{{route('Cashier')}}/buttonAction/loadDataMethod/"+billNumber);
                }
            });
            
        });
        
        $("#tBelanja").mask('000.000.000', {reverse: true});
        $("#tPembayaran").mask('000.000.000', {reverse: true});
        $("#nomSelisih").mask('000.000.000', {reverse: true});
        $("#kredit").mask('000.000.000', {reverse: true});
        $("#tPlusKredit").mask('000.000.000', {reverse: true});
        $("#lastPayment").mask('000.000.000', {reverse: true});
        $(".type-account").mask('000.000.000', {reverse: true});
        
        $("#tPlusKredit").on('input', computeBayar);
        $("#tPembayaran").on('input', computeBayar);
        $("#nomSelisih").on('input', computeBayar);
        $("#ppn2").on('input', computeBayar);
        
        function computeBayar(){
            let valBayar = "{{$totalBayar->totalBilling}}",
                valBelanja = $("#tPlusKredit").val(),
                valPembayaran = $("#tPembayaran").val(),
                valPPN2 = $("#ppn2").val(),
                
                inputBelanja = valBelanja.replace(/\./g, ""),
                inputPembayaran = valPembayaran.replace(/\./g, "");
                
            if (typeof inputPembayaran == "undefined" || typeof inputPembayaran == "0") {
                return
            }
            
            let ppn = $("#ppn").val(),
                percBilling = parseInt(valBayar) * (valPPN2 / 100),
                totalPaymentDisplay = (parseInt(valBayar) + parseInt(percBilling));
            
            
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
        
        let billPembayaran = "{{$noBill}}",
            valBelanja = "{{$totalBayar->totalBilling}}",
            valHutang = "{{$nominalKredit}}",
            kreditLimit = "{{$dataBilling->kredit_limit}}";
        
        $("#btnBatalTrx").click(function(){
            event.preventDefault();
            window.location.reload();
        })
        var checkBoxLunas = document.getElementById("lunasiHutang"),
            selisih = "{{$nilaiNextBayar}}";
        var checkBox2 = document.getElementById("radioMethod");
        $("#btnSimpanTrx").click(function(){
            event.preventDefault();
            let typeCetak = $("#typeCetak").val(),
                    totalPembayaran = $("#tPembayaran").val(),
                    tBelanja = $("#tBelanja").val(),
                    tKredit = $("#kredit").val();

            let replaceTotalPembayaran = totalPembayaran.replace(/\./g, ""),
                    replaceKredit = tKredit.replace(/\./g, ""),
                    replacetBelanja = tBelanja.replace(/\./g, "");
            //alert(kreditLimit);

            let penguranganTunai = parseInt(valBelanja) - parseInt(replaceTotalPembayaran),
                totalHutang = parseInt(replaceKredit) + parseInt(penguranganTunai),
                totalHarusDibayar = parseInt(replacetBelanja) + parseInt(replaceKredit);

            if (kreditLimit === '0' &&  replaceTotalPembayaran < valBelanja) {
                $(".notive-display").fadeIn();
                $("#notiveDisplay").html("Pelanggan ini tidak dapat melakukan transaksi kredit!");
            }
            else if (totalHutang > kreditLimit && kreditLimit !== '0' && replaceTotalPembayaran < valBelanja && checkBoxLunas.checked == false) {
                alertify
                .alert("Hutang Customer Sudah Melewati Limit !", function(){
                    alertify.message('Transaksi di batalkan.');
                }).set({title:"Konfirmasi Limit Hutang"});
            }
            // else if (replaceTotalPembayaran < replaceKredit && replaceTotalPembayaran > valBelanja) {
            //     $(".notive-display").fadeIn();
            //     $("#notiveDisplay").html("Untuk pembayaran kurang dari nominal : Rp. "+tKredit+", gunakan menu PELUNASAN [F9] untuk pembayaran secara partial. Lakukan pembayaran TUNAI terlebih dahulu dengan nominal : Rp."+tBelanja+", kemudian bayar hutang secara partial.");
            // }
            else if (parseInt(replaceTotalPembayaran) >= parseInt(replaceKredit) && parseInt(replaceTotalPembayaran) >= totalHarusDibayar && replaceKredit !== '0' && checkBoxLunas.checked == false) {
                $(".notive-display").fadeIn();
                $("#notiveDisplay").html("Wajib check list LUNASI HUTANG untuk pelunasan hutang sebelumnya!");
            }
            else {
                inputPembayaran(billPembayaran, typeCetak);
            }            
            // alert(replaceTotalPembayaran+">="+replaceKredit+";"+totalHarusDibayar);
        })
        
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && event.key === 's') { // Cetak
                event.preventDefault();
                let typeCetak = $("#typeCetak").val(),
                    totalPembayaran = $("#tPembayaran").val(),
                    tBelanja = $("#tBelanja").val(),
                    tKredit = $("#kredit").val();
                let replaceTotalPembayaran = totalPembayaran.replace(/\./g, ""),
                    replaceKredit = tKredit.replace(/\./g, ""),
                    replacetBelanja = tBelanja.replace(/\./g, "");

                let penguranganTunai = parseInt(valBelanja) - parseInt(replaceTotalPembayaran),
                totalHutang = parseInt(replaceKredit) + parseInt(penguranganTunai),
                totalHarusDibayar = parseInt(replacetBelanja) + parseInt(replaceKredit);
                
                // alert (totalHutang+">"+kreditLimit+" / "+ valBelanja + " / " + penguranganTunai + " / " + replaceTotalPembayaran + " / " + replaceKredit);
                if (kreditLimit === '0' && replaceTotalPembayaran < valBelanja) {
                    $(".notive-display").fadeIn();
                    $("#notiveDisplay").html("Pelanggan ini tidak dapat melakukan transaksi kredit!");
                }
                else if (parseInt(totalHutang) > parseInt(kreditLimit) && parseInt(kreditLimit) !== '0' && parseInt(replaceTotalPembayaran) < parseInt(valBelanja) && checkBoxLunas.checked == false) {
                    alertify
                    .alert("Hutang Customer Sudah Melewati Limit ! " + totalHutang, function(){
                        window.location.reload();
                    }).set({title:"Konfirmasi Limit Hutang"});
                }
                // else if (replaceTotalPembayaran < replaceKredit && replaceTotalPembayaran > valBelanja) {
                //     $(".notive-display").fadeIn();
                //     $("#notiveDisplay").html("Pembayaran hutang tidak boleh kurang dari nominal hutang sebelumnya : Rp. "+tKredit+". Transaksi pembayaran hutang tanpa pelunasan dapat dilakukan secara parsial di menu PELUNASAN [F9]. Lakukan pembayaran TUNAI terlebih dahulu dengan nominal : Rp."+tBelanja+", kemudian bayar hutang secara partial.");
                // }
                else if (parseInt(replaceTotalPembayaran) >= parseInt(replaceKredit) && parseInt(replaceTotalPembayaran) >= totalHarusDibayar && replaceKredit !== '0' && checkBoxLunas.checked == false) {
                    $(".notive-display").fadeIn();
                    $("#notiveDisplay").html("Wajib check list LUNASI HUTANG untuk pelunasan hutang sebelumnya!");
                }
                else {
                    inputPembayaran(billPembayaran, typeCetak);
                }
                // alert(replaceTotalPembayaran+">="+replaceKredit+";"+valBelanja+";"+totalHarusDibayar);
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

        function inputPembayaran(billPembayaran, typeCetak)
        {
            let urlPrint = "{{route('Cashier')}}/buttonAction/printTemplateCashier/"+billPembayaran+"/"+typeCetak;
            let data_form = new FormData(document.getElementById("formPembayaran"));
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
    });
    function myFunctionChecked() {
      var checkBox = document.getElementById("radioMethod");
      var tablePayment = document.getElementById("tableMethod");
      if (checkBox.checked == true){
        tablePayment.style.display = "block";
      } else {
        tablePayment.style.display = "none";
      }
    }
</script>