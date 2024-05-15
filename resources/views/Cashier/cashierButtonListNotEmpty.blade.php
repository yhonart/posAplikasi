<form id="FormPayment" autocomplete="off">
    <dl class="row">
        <dd class="col-12 text-right">
            <div class="input-group">
                <input type="text" class="form-control form-control-lg font-weight-bold" name="totalPayment" id="totalPayment" value="{{$trPaymentInfo->t_bill}}" readonly>
                    <div class="input-group-append">
                    <span class="input-group-text"><i class="fa-solid fa-rupiah-sign"></i></span>
                </div>
            </div>           
            <input type="hidden" name="HiddenPayment" id="HiddenPayment" class="form-control form-control-lg font-weight-bold" value="{{$trPaymentInfo->t_bill}}" readonly>            
        </dd>
    </dl>
    <div class="form-group row align-items-end ">
        <label for="tBayar" class="form-label col-4">Pembayaran</label>
        <div class="col-8">
            <input type="text" name="tBayar" id="tBayar" class="form-control">
        </div>
    </div>
    <div class="form-group row align-items-end ">
        <label for="tSelisih" class="form-label col-4">Pengembalian</label>
        <div class="col-8">
            <input type="text" name="tSelisih" id="tSelisih" class="form-control font-weight-bold text-danger" readonly>
        </div>
    </div>
    <hr>
    <div class="form-group row align-items-end">
        <label for="noStruck" class="form-label col-4">No Struck</label>
        <div class="col-8">
            <input type="text" name="noStruck" id="noStruck" class="form-control form-control-sm" value="{{$trPaymentInfo->billing_number}}" readonly>
        </div>
    </div>
    <div class="form-group row align-items-end ">
        <label for="pelanggan" class="form-label col-4">Pelanggan</label>
        <div class="col-8">
            <input type="text" name="pelanggan" id="pelanggan" class="form-control form-control-sm" value="{{$trPaymentInfo->customer_name}}" readonly>
        </div>
    </div>
    <div class="form-group row align-items-end ">
        <label for="tItem" class="form-label col-4">Total Item</label>
        <div class="col-8">
            <input type="text" name="tItem" id="tItem" class="form-control form-control-sm" value="{{$trPaymentInfo->t_item}}" readonly>
        </div>
    </div>
    <div class="form-group row align-items-end ">
        <label for="pengiriman" class="form-label col-4">Pengiriman</label>
        <div class="col-8">
            <select name="pengiriman" id="pengiriman" class="form-control form-control-sm">
                <option value="{{$trPaymentInfo->tr_delivery}}" readonly>{{$trPaymentInfo->tr_delivery}}</option>
                @foreach($delivery as $d)
                    @if($d->idm_delivery <> $trPaymentInfo->tr_delivery)
                    <option value="{{$d->idm_delivery}}">{{$d->delivery_name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="form-group row align-items-end mb-4">
        <label for="ppn" class="form-label col-4">PPN</label>
        <div class="col-4">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" name="ppn" id="ppn">
                    <div class="input-group-append">
                    <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                </div>
            </div>            
        </div>
        <div class="col-4">
            <input type="text" class="form-control form-control-sm" name="nominalPPN" id="nominalPPN">
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-4">
            <button type="button" class="btn bg-navy elevation-1 btn-block p-0">[F5] <br> Load</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-navy elevation-1 btn-block p-0">[F6] <br> Dt.Penjualan</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-navy elevation-1 btn-block p-0">[F7] <br> Point</button>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-4">
            <button type="button" class="btn bg-lightblue btn-block p-0">[F8] <br> Check Stock</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-lightblue btn-block p-0">[F9] <br> Pelunasan</button>
        </div>        
        <div class="col-4">
            <button type="button" class="btn btn-danger btn-block p-0">[F10] <br> Return</button>
        </div>
    </div>
    <div class="row ">
        <div class="col-4">
            <button type="button" class="btn btn-success btn-block font-weight-bold p-0">[Ctrl+B] <br> BAYAR</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-dark btn-block font-weight-bold p-0">[Ctrl+S] <br> Simpan Tr</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-navy btn-block font-weight-bold p-0">[Ctrl+x] <br> Keluar</button>
        </div>
        
    </div>
</form>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<script src="{{asset('public/js/cashierButton.js')}}"></script>
<script>
    $(document).ready(function(){
        let el_modal_all = $('.MODAL-CASHIER'),
            el_modal_sm = $('#modal-global-sm'),
            id_modal_content_cashier = '.MODAL-CONTENT-CASHIER',
            url_cashier = "{{route('Cashier')}}";

        let t_Belanja = $("input[name=totalPayment]").val(),
            hidden_tBelanja = $("#HiddenPayment").val(),
            no_Struck = $("#noStruck").val(),
            pelanggan = $("#pelanggan").find(":selected").val(),
            t_Selisih = $("input[name=tSelisih]").val(),
            t_Item = $("input[name=tItem]").val(),
            pengiriman = $("#pengiriman").find(":selected").val();
            

        document.addEventListener('keydown', function(event) {
    
            if (event.key === 'F1') { // Menampilkan modal bantuan
                event.preventDefault();
                el_modal_sm.modal('show').find(id_modal_content_cashier).load(url_cashier + "/buttonAction/loadHelp");
            }
            else if (event.key === 'F2') { // Mengarahkan ke field pelanggan untuk di pilih.
                event.preventDefault();
                var selectField = document.getElementById('pelanggan');
                selectField.focus();
                selectField.click();
            }
            else if (event.ctrlKey && event.key === 'x') { // Keluar dari halaman / logout.
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
            else if (event.ctrlKey && event.key === 's') {
                event.preventDefault();            
                $.ajax({
                    type : 'get',
                    url : "{{route('Cashier')}}/buttonAction/updateToSave/"+no_Struck,
                    success : function(data){                  
                        loadTableData();                
                        window.location.reload();             
                    }
                });
            }
            else if (event.ctrlKey && event.key === 'b') {
                event.preventDefault();
                let t_Bayar = $("#tBayar").val(),
                    Bayar = t_Bayar.replace(/\./g, ""),
                    ppn = $("#ppn").val();
                    ppnNominal = $("#nominalPPN").val();
                                    
                if (Bayar < hidden_tBelanja) {
                    toastr.error('TRANSAKSI TIDAK DAPAT DI PROSES ! Nominal pembayaran kurang dari subTotal pembelian')
                }
                else{
                    $.ajax({
                        type : 'post',
                        url : "{{route('Cashier')}}/buttonAction/updateToPayment",  
                        data : {noBill:no_Struck,ppn:ppn,ppnNominal:ppnNominal,tBayar:t_Bayar,tBill:hidden_tBelanja},           
                        success : function(data){                  
                            loadTableData();                
                            window.location.reload();             
                        }
                    });
                }  
            }
            else if (event.key === 'F6') {
                event.preventDefault();
                el_modal_sm.modal('show').find(id_modal_content_cashier).load(url_cashier + "/buttonAction/dataPenjualan");
            }
            else if (event.key === 'F8') {
                event.preventDefault();
                el_modal_sm.modal('show').find(id_modal_content_cashier).load(url_cashier + "/buttonAction/dataStock")
            }
            else if (event.key === 'F9') {
                event.preventDefault();
                el_modal_sm.modal('show').find(id_modal_content_cashier).load(url_cashier + "/buttonAction/dataPelunasan")
            }
            else if (event.key === 'F10') {
                event.preventDefault();
                el_modal_sm.modal('show').find(id_modal_content_cashier).load(url_cashier + "/buttonAction/dataReturn")
            }
        });
});
    // INPUT TOTAL PENGEMBALIAN
    $('#tBayar').mask('000.000.000', {reverse: true});
    $('#tSelisih').mask('000.000.000', {reverse: true});
    $('#totalPayment').mask('000.000.000', {reverse: true});
    
    $("#tBayar").on('input', compute1);
    $("#totalPayment").on('input', compute1);
    $("#ppn").on('input', compute1);

    function compute1(){
        let bayar = $("#tBayar").val(),
            billing = $("#HiddenPayment").val(),            
            inputBayar = bayar.replace(/\./g, ""),
            inputBilling = billing.replace(/\./g, "");

        if (typeof inputBayar == "undefined" || typeof inputBayar == "0") {
            return
        }
        // alert(percBilling);
        $("#tSelisih").val(accounting.formatMoney(parseInt(inputBayar) - parseInt(inputBilling),{
            symbol: "",
            precision: 0,
	        thousand: ".",
        })); 

        let ppn = $("#ppn").val(),
            percBilling = parseInt(inputBilling) * (ppn / 100),
            totalPaymentDisplay = (parseInt(inputBilling) + parseInt(percBilling));            

        $("#nominalPPN").val(accounting.formatMoney(percBilling,{
            symbol: "",
            precision: 0,
	        thousand: ".",
        }));

        $("#totalPayment").val(accounting.formatMoney(totalPaymentDisplay,{
            symbol: "",
            precision: 0,
	        thousand: ".",
        }));
    }
</script>