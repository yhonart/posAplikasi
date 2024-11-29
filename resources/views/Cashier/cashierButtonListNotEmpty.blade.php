<div class="card">
    <div class="card-body">
        <dl class="row">
            <dd class="col-12">
                <div id="totalBelanja"></div>
            </dd>
        </dl>        
        <div class="form-group row">
            <label for="noStruck" class="form-label col-md-4">No Struck</label>
            <div class="col-8">
                <input type="hidden" name="tBayar" id="tBayar" value="0">
                <input type="hidden" name="tSelisih" id="tSelisih" readonly>
                <input type="hidden" name="totalPayment" id="totalPayment" value="{{$totalPayment->totalBilling}}" readonly>
                <input type="text" name="noStruck" id="noStruck" class="form-control " value="{{$trPaymentInfo->billing_number}}" readonly>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="pelanggan" class="form-label col-md-4">Pelanggan</label>
            <div class="col-md-8">
                <select name="pelanggan" id="pelanggan" class="form-control form-control-sm">
                    <option value="{{$trPaymentInfo->member_id}}">{{$trPaymentInfo->customer_name}}</option>
                    @foreach($members as $m)   
                        @if($m->idm_customer <> $trPaymentInfo->member_id)
                        <option value="{{$m->idm_customer}}">{{$m->customer_store}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>   
        <dl class="row">
            <dt class="col-md-4">Tipe Pelanggan</dt>
            <dd class="col-md-8">: {{$customerType->group_name}}</dd>
            <dt class="col-md-4">Alamat</dt>
            <dd class="col-md-8">: {{$trPaymentInfo->address}}</dd>
            <dt class="col-md-4">Point Belanja</dt>
            <dd class="col-md-8">: 
                <?php
                    // if ($trPoint->point <> '') {
                    //     echo "Rp. ".number_format($trPoint->point,'0',',','.');
                    // }
                    echo "0";
                ?>                
            </dd>
            <dt class="col-md-4">Limit Hutang :</dt>
            <dd class="col-md-8">: 
                @if(!empty($nomKredit))
                    @if($nomKredit->nom_kredit < $customerType->kredit_limit)
                        <i class="fa-solid fa-rupiah-sign"></i> {{number_format($nomKredit->nom_kredit,'0',',','.')}}
                        @else
                        <i class="fa-solid fa-rupiah-sign"></i>
                        <span class="text-danger font-weight-bold">{{number_format($nomKredit->nom_kredit,'0',',','.')}}</span>
                    @endif
                @else
                <i class="fa-solid fa-rupiah-sign"></i> 0
                @endif
                / <b><i class="fa-solid fa-rupiah-sign"></i> {{number_format($customerType->kredit_limit,'0',',','.')}}</b></dd>
        </dl>  
        <hr>
        
        <div class="form-group row mb-4">
            <label for="ppn" class="form-label col-4">PPN</label>
            <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm form-control-border" name="ppn" id="ppn">
                        <div class="input-group-append">
                        <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                    </div>
                </div>            
            </div>
            <div class="col-4">
                <input type="text" class="form-control form-control-sm form-control-border" name="nominalPPN" id="nominalPPN">
            </div>
        </div>
        
        <div class="row mb-2">
            <div class="col-4">
                <button type="button" class="btn bg-gradient-success elevation-2 btn-block border border-2 border-light p-2" id="btnBayar"><b>[F2]</b> <br> BAYAR</button>
            </div>
            <div class="col-4">
                <button type="button" class="btn btn-primary elevation-2 btn-block border border-2 border-light p-2" id="btnPenjualan"><b>[F6]</b> <br>Dt. Penjualan</button>
            </div>
            <div class="col-4">
                <button type="button" class="btn btn-primary elevation-2 btn-block border border-2 border-light p-2" id="btnClear"><b>[F4]</b> <br>Clear</button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4">
                <button type="button" class="btn btn-primary elevation-2 btn-block border border-2 border-light p-2" id="btnPoint"><b>[F7]</b> <br> Point</button>
            </div>
            <div class="col-4">
                <button type="button" class="btn bg-gradient-primary elevation-2 btn-block border border-2 border-light p-2" id="btnPelunasan"><b>[F9]</b> <br> Pelunasan</button>
            </div>
            <div class="col-4">
                <button type="button" class="btn bg-gradient-danger elevation-2 btn-block border border-2 border-light p-2" id="btnReturn"><b>[F10]</b> <br> Return</button>
            </div>
        </div>
        <div class="row mb-2">
            <!--<div class="col-4">-->
            <!--    <button type="button" class="btn bg-gradient-danger elevation-2 btn-block border border-2 border-light p-2" id="btnDelete"><b>[Ctrl+D]</b> <br> Hapus Data</button>-->
            <!--</div>-->
            <div class="col-4">
                <button type="button" class="btn bg-gradient-indigo elevation-2 btn-block border border-2 border-light p-2" id="btnHold"><b>[Ctrl+H]</b> <br> HOLD</button>
            </div>
            <div class="col-4">
                <button type="button" class="btn bg-gradient-purple elevation-2 btn-block border border-2 border-light p-2" id="btnLoad"><b>[Ctrl+L]</b> <br> LOAD</button>
            </div>
            <div class="col-4">
                <button type="button" class="btn bg-gradient-navy elevation-2 btn-block border border-2 border-light p-2" id="btnLogOut"><b>[Ctrl+X]</b> <br> Log-Out</button>
            </div>
        </div>
    </div>
</div>

<div class="modal MODAL-GLOBAL" id="modal-global-large" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop='static'>
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content MODAL-CONTENT-GLOBAL">
          <!-- Content will be placed here -->
          <!-- class default MODAL-BODY-GLOBAL -->
      </div>
  </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<script>
    $(function(){
        $("#pelanggan").select2({
            width: 'resolve'
        });
    })
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var el_modal_all = $('.MODAL-GLOBAL'),
            el_modal_large = $('#modal-global-large'),
            id_modal_content = '.MODAL-CONTENT-GLOBAL';
            
        el_modal_all.on('show.bs.modal', function () {
            global_style.container_spinner($(this).find(id_modal_content));
        });
        el_modal_all.on('hidden.bs.modal', function () {
            $(this).find(id_modal_content).html('');
        });
            
        var routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");

        $("#pelanggan").change(function(){
            var idPelanggan = $(this).find(":selected").val(),
                trxCode = "{{$trPaymentInfo->billing_number}}";
                
            $.ajax({
                type : 'post',
                url : "{{route('Cashier')}}/buttonAction/postUpdateCustomer",
                data :  {idPelanggan:idPelanggan, trxCode:trxCode},
                success : function(data){                
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);                    
                }
            }); 
        });
        
        $(document).on('click','.BTN-OPEN-MODAL-GLOBAL-LG', function(e){
            e.preventDefault();
            el_modal_large('show').find(id_modal_content).load($(this).attr('href'));
        });
        el_modal_all.on('show.bs.modal', function () {
            global_style.container_spinner($(this).find(id_modal_content));
        });
        el_modal_all.on('hidden.bs.modal', function () {
            $(this).find(id_modal_content).html('');
        });
        
        const url_cashier = "{{route('Cashier')}}";
        var trxCode = "{{$trPaymentInfo->billing_number}}";
        totalBelanja(trxCode);
        
        function totalBelanja(trxCode){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/updateTotalBeanja/"+trxCode,
                success : function(response){
                    $('#totalBelanja').html(response);
                }
            });
        }
        
        var t_Belanja = $("input[name=totalPayment]").val(),
            hidden_tBelanja = $("#HiddenPayment").val(),
            no_Struck = $("#noStruck").val(),
            pelanggan = $("#pelanggan").find(":selected").val(),
            t_Selisih = $("input[name=tSelisih]").val(),
            t_Item = $("input[name=tItem]").val();
            
        $("#btnBayar").click(function(){
            event.preventDefault();
            var t_Bayar = $("#tBayar").val(),
                Bayar = t_Bayar.replace(/\./g, "");
                el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/modalPembayaran/"+no_Struck+"/"+hidden_tBelanja+"/"+Bayar);
        });
        $("#btnPenjualan").click(function(){
            event.preventDefault();
           el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataPenjualan");
        });
        $("#btnClear").click(function(){
            event.preventDefault();
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/deleteAllTrx/"+no_Struck,
                success : function(data){                  
                    loadTableData();                
                    window.location.reload();             
                }
            });
        });
        $("#btnPoint").click(function(){
            toastr.error('Item ini belum dapat ditampilkan')
        });
        $("#btnPelunasan").click(function(){
            event.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataPelunasan");
        });
        $("#btnReturn").click(function(){
            event.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataReturn");
        });
        $("#btnHold").click(function(){
            event.preventDefault();
            holdTransaksi();
        });
        $("#btnLoad").click(function(){
            event.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/loadDataSaved");
        });
        $("#btnLogOut").click(function(){
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
        
        document.addEventListener('keydown', function(event) {
    
            if (event.ctrlKey && event.key === 'l') { // Menampilkan modal bantuan
                event.preventDefault();
                el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/loadDataSaved");
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
                holdTransaksi();
            }
            else if (event.key === 'F2') { // Perintah bayar
                event.preventDefault();
                let t_Bayar = $("#tBayar").val(),
                    Bayar = t_Bayar.replace(/\./g, "");
                    el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/modalPembayaran/"+no_Struck+"/"+hidden_tBelanja+"/"+Bayar);
            }
            else if (event.ctrlKey && event.key === 'd') { // Perintah bayar
                event.preventDefault();
                let trxCode = "{{$trPaymentInfo->billing_number}}";
                    el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/modalDelete/"+trxCode);
            }
            else if (event.key === 'F6') {
                event.preventDefault();
                el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataPenjualan");
            }
            else if (event.key === 'F8') {
                event.preventDefault();
                el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataStock");
            }
            else if (event.key === 'F9') {
                event.preventDefault();
                el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataPelunasan");
            }
            else if (event.key === 'F10') {
                event.preventDefault();
                el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataReturn");
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

        function holdTransaksi(){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/updateToSave/"+no_Struck,
                success : function(data){                  
                    loadTableData();                
                    window.location.reload();             
                }
            });
        }
    }) 
    
    // INPUT TOTAL PENGEMBALIAN
    $('#tBayar').mask('000.000.000', {reverse: true});
    $('#tSelisih').mask('000.000.000', {reverse: true});
    $('#totalPayment').mask('000.000.000', {reverse: true});
    
    $("#tBayar").on('input', compute1);
    $("#totalPayment").on('input', compute1);
    $("#ppn").on('input', compute1);
    
    
    function compute1(){
        var bayar = $("#tBayar").val(),
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

        var ppn = $("#ppn").val(),
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