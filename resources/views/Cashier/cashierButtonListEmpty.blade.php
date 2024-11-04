<form id="FormPayment" autocomplete="off">
    <div class="form-group row align-items-end">
        <label for="noStruck" class="form-label col-4">No Struck</label>
        <div class="col-8">
            <input type="text" name="noStruck" id="noStruck" class="form-control form-control-lg" value="{{$pCode}}" readonly>
        </div>
    </div>

    <div class="form-group row align-items-end">
        <label for="pelanggan" class="form-label col-4">Member [F1]</label>
        <div class="col-8">
            <select name="pelanggan" id="pelanggan" class="form-control form-control-lg select2">
                <option value="0"></option>
                @foreach($members as $m)                    
                    <option value="{{$m->idm_customer}}">
                        {{$m->customer_store}} / {{$m->address}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row" id="spinnerSelectCus" style="display: none;">
        <div class="col-md-12">
            <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <span>Please Wait !</span>
        </div>
    </div>

    <div class="form-group row">
        <div class="input-group col-12">
            <input type="hidden" name="totalPayment" id="totalPayment" class=" form-control form-control-sm" value="0">
            <input type="hidden" name="tBayar" id="tBayar" class="form-control form-control-sm" value="0">
            <input type="hidden" name="tSelisih" id="tSelisih" class="form-control form-control-sm" value="0">
            <input type="hidden" name="tItem" id="tItem" class="form-control form-control-sm" value="0">
            <input type="hidden" name="pengiriman" id="pengiriman" class="form-control form-control-sm" value="0">
            <input type="hidden" name="ppn" id="ppn" class="form-control form-control-sm" value="0">
        </div>
        
    </div>

    <div class="row mb-2">
        <div class="col-4">
            <button type="button" class="btn bg-gradient-success elevation-2 btn-block border border-2 border-light p-2" id="btnBayar" disabled><b>[F2]</b> <br> BAYAR</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary elevation-2 btn-block border border-2 border-light p-2" id="btnPembayaran"><b>[F6]</b> <br> Dt. Penjualan</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary elevation-2 btn-block border border-2 border-light p-2" id="btnClear" disabled><b>[F4]</b> <br>Tutup</button>
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
        <div class="col-4">
            <button type="button" class="btn bg-gradient-indigo elevation-2 btn-block border border-2 border-light p-2" id="btnHold" disabled><b>[Ctrl+H]</b> <br> HOLD</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-gradient-purple elevation-2 btn-block border border-2 border-light p-2" id="btnLoad"><b>[Ctrl+L]</b> <br> LOAD</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-gradient-navy elevation-2 btn-block border border-2 border-light p-2" id="btnLogOut"><b>[Ctrl+X]</b> <br> Log-out</button>
        </div>
    </div>
</form>
<div class="modal MODAL-GLOBAL" id="modal-global-large" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<script src="{{asset('public/js/cashierButton.js')}}"></script>
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var el_modal_all = $('.MODAL-GLOBAL'),
        el_modal_large = $('#modal-global-large'),
        id_modal_content = '.MODAL-CONTENT-GLOBAL',
        url_cashier = "{{route('Cashier')}}";
            
    el_modal_all.on('show.bs.modal', function () {
        global_style.container_spinner($(this).find(id_modal_content));
    });
    el_modal_all.on('hidden.bs.modal', function () {
        $(this).find(id_modal_content).html('');
    });

    var t_Belanja = $("input[name=totalPayment]").val(),
        no_Struck = $("input[name=noStruck]").val(),
        idPelanggan = $("#pelanggan").find(":selected").val(),
        t_Bayar = $("input[name=tBayar]").val(),
        t_Selisih = $("input[name=tSelisih]").val(),
        t_Item = $("input[name=tItem]").val(),
        pengiriman = $("#pengiriman").find(":selected").val(),
        ppn = $("#ppn").find(":selected").val();
    
    $(function () {
        $("#pelanggan").select2({
            width: 'resolve'
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });
    $("#btnPoint").click(function(){
        toastr.error('Item ini belum dapat ditampilkan')
    });
    $("#btnReturn").click(function(){
        event.preventDefault();
        el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataReturn");
    });
    $("#btnPelunasan").click(function(){
        event.preventDefault();
        el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataPelunasan");
    });
    $("#btnHold").click(function(){
        event.preventDefault();
        el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataReturn");
    });
    $("#btnLoad").click(function(){
        event.preventDefault();
        el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/loadDataSaved");
    });
    $("#btnPembayaran").click(function(){
        event.preventDefault();
        el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataPenjualan");
    });
    $("#btnLogOut").click(function(){
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });

    document.addEventListener('keydown', function(event) {
        
        if (event.ctrlKey && event.key === 'h') { // Menampilkan modal bantuan
            event.preventDefault();
            toastr.error('Tidak ada transaksi yang dapat di simpan !')
        }
        else if (event.ctrlKey && event.key === 'l') { // Menampilkan modal bantuan
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
        else if (event.key === 'F6') {
            event.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataPenjualan");
        }
        else if (event.ctrlKey && event.key === 'b') {
            event.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/loadHelp");
        }
        else if (event.key === 'F7') {
            event.preventDefault();
            toastr.error('Tidak dapat menampilkan data, dikarenakan tidak ada nama pelanggan yang dipilih')
        }
        else if (event.key === 'F9') {
            event.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataPelunasan")
        }
        else if (event.key === 'F10') {
            event.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load(url_cashier + "/buttonAction/dataReturn")
        }
    });
    $(document).ready(function(){
        var routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");

        $("#pelanggan").change(function(){
            $("#spinnerSelectCus").fadeIn("slow");
            idPelanggan = $(this).find(":selected").val();
            $.ajax({
                type : 'post',
                url : "{{route('Cashier')}}/buttonAction/postVariableData",
                data :  {t_Belanja:t_Belanja, pelanggan:idPelanggan, t_Bayar:t_Bayar, t_Selisih:t_Selisih, t_Item:t_Item, pengiriman:pengiriman, ppn:ppn},
                success : function(data){                
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                    $("#spinnerSelectCus").fadeOut("slow");                    
                }
            }); 
        });
    });
</script>