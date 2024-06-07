<form id="FormPayment" autocomplete="off">
    <dl class="row">
        <dd class="col-12 text-right">
            <div class="input-group row">
                <div class="col-12">
                    <h1 class="bg-info p-2 elevation-1"><i class="fa-solid fa-rupiah-sign"></i> {{number_format($totalPayment->totalBilling,0,',','.')}}</h1>
                </div>
                <input type="hidden" class="form-control form-control-xl font-weight-bold" name="totalPayment" id="totalPayment" value="{{$totalPayment->totalBilling}}" readonly>
            </div>           
            <input type="hidden" name="HiddenPayment" id="HiddenPayment" class="form-control form-control-lg font-weight-bold" value="{{$totalPayment->totalBilling}}" readonly>            
        </dd>
    </dl>
    <div class="form-group row align-items-end ">
        <label for="tBayar" class="form-label col-4">Pembayaran</label>
        <div class="col-8">
            <input type="text" name="tBayar" id="tBayar" class="form-control form-control-sm" value="0">
        </div>
    </div>
    <div class="form-group row align-items-end ">
        <label for="tSelisih" class="form-label col-4">Pengembalian</label>
        <div class="col-8">
            <input type="text" name="tSelisih" id="tSelisih" class="form-control font-weight-bold form-control-sm text-danger" readonly>
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
            <input type="text" name="tItem" id="tItem" class="form-control form-control-sm" value="{{$totalPayment->countList}}" readonly>
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
    
    <div class="row mb-2">
        <div class="col-4">
            <button type="button" class="btn bg-gradient-success elevation-2 btn-block border border-2 border-light p-2"><b>[F2]</b> <br> BAYAR</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary elevation-2 btn-block border border-2 border-light p-2"><b>[Ctrl+A]</b> <br> DT.PENJUALAN</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary elevation-2 btn-block border border-2 border-light p-2"><b>[F4]</b> <br> CLEAR</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4">
            <button type="button" class="btn btn-primary elevation-2 btn-block border border-2 border-light p-2"><b>[F7]</b> <br> POINT</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-gradient-primary elevation-2 btn-block border border-2 border-light p-2"><b>[F9]</b> <br> PELUNASAN</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-gradient-danger elevation-2 btn-block border border-2 border-light p-2"><b>[F10]</b> <br> RETURN</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4">
            <button type="button" class="btn bg-gradient-indigo elevation-2 btn-block border border-2 border-light p-2"><b>[Ctrl+H]</b> <br> HOLD</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-gradient-purple elevation-2 btn-block border border-2 border-light p-2"><b>[Ctrl+L]</b> <br> LOAD</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-gradient-navy elevation-2 btn-block border border-2 border-light p-2"><b>[Ctrl+X]</b> <br> LOG-OUT</button>
        </div>
    </div>
</form>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<script src="{{asset('public/js/cashierButton.js')}}"></script>
<script>
    $(document).ready(function(){
        let el_modal_all = $('.MODAL-GLOBAL'),
            el_modal_sm = $('#modal-global-large'),
            id_modal_content_cashier = '.MODAL-CONTENT-GLOBAL',
            url_cashier = "{{route('Cashier')}}";

        let t_Belanja = $("input[name=totalPayment]").val(),
            hidden_tBelanja = $("#HiddenPayment").val(),
            no_Struck = $("#noStruck").val(),
            pelanggan = $("#pelanggan").find(":selected").val(),
            t_Selisih = $("input[name=tSelisih]").val(),
            t_Item = $("input[name=tItem]").val();
            

        document.addEventListener('keydown', function(event) {
    
            if (event.ctrlKey && event.key === 'l') { // Menampilkan modal bantuan
                event.preventDefault();
                el_modal_sm.modal('show').find(id_modal_content_cashier).load(url_cashier + "/buttonAction/loadDataSaved");
            }
            else if (event.key === 'F1') { // Mengarahkan ke field pelanggan untuk di pilih.
                event.preventDefault();
                var selectField = document.getElementById('pelanggan');
                selectField.focus();
                selectField.click();
            }
            else if (event.ctrlKey && event.key === 'x') { // Keluar dari halaman / logout.
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
            else if (event.ctrlKey && event.key === 'h') { // Simpan transaksi atau HOLD transaksi
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
            else if (event.key === 'F2') { // Perintah bayar
                event.preventDefault();
                let t_Bayar = $("#tBayar").val(),
                    Bayar = t_Bayar.replace(/\./g, ""),
                    ppn = $("#ppn").val();
                    ppnNominal = $("#nominalPPN").val();
                    el_modal_sm.modal('show').find(id_modal_content_cashier).load(url_cashier + "/buttonAction/modalPembayaran/"+no_Struck+"/"+hidden_tBelanja+"/"+Bayar);
            }
            else if (event.ctrlKey && event.key === 'a') {
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
            else if (event.key === 'F4') {
                event.preventDefault();
                $.ajax({
                    type : 'get',
                    url : "{{route('Cashier')}}/buttonAction/deleteAllTrx/"+no_Struck,
                    success : function(data){                  
                        loadTableData();                
                        window.location.reload();             
                    }
                });
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