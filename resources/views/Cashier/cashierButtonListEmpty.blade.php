<form id="FormPayment" autocomplete="off">
    <div class="form-group row align-items-end">
        <label for="noStruck" class="form-label col-4">No Struck</label>
        <div class="col-8">
            <input type="text" name="noStruck" id="noStruck" class="form-control form-control-lg" value="{{$pCode}}" readonly>
        </div>
    </div>

    <div class="form-group row align-items-end ">
        <label for="pelanggan" class="form-label col-4">Member [F2]</label>
        <div class="col-8">
            <select name="pelanggan" id="pelanggan" class="form-control form-control-lg select2 select2-danger" data-dropdown-css-class="select2-danger">
                <option value="0"></option>
                @foreach($members as $m)                    
                    <option value="{{$m->idm_customer}}">{{$m->customer_store}}</option>
                @endforeach
            </select>
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

    <div class="row mb-1">
        <div class="col-4">
            <button type="button" class="btn bg-navy elevation-1 btn-block p-0 font-weight-bold">[F5] <br> Load</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-navy elevation-1 btn-block p-0 font-weight-bold">[F6] <br> Dt.Penjualan</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-light elevation-1 btn-block p-0 font-weight-bold" disabled>[F7] <br> Point</button>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-4">
            <button type="button" class="btn btn-primary elevation-1 font-weight-bold btn-block p-0">[F8] <br> Check Stock</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary elevation-1 font-weight-bold btn-block p-0">[F9] <br> Pinjaman</button>
        </div>        
        <div class="col-4">
            <button type="button" class="btn btn-danger elevation-1 btn-block p-0">[F10] <br> Return</button>
        </div>
    </div>
    <div class="row ">
        <div class="col-4">
            <button type="button" class="btn btn-light elevation-1 btn-block font-weight-bold p-0" disabled>[Ctrl+B] <br> BAYAR</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-light elevation-1 btn-block font-weight-bold p-0" disabled>[Ctrl+S] <br> Simpan Tr</button>
        </div>
        <div class="col-4">
            <button type="button" class="btn bg-navy elevation-1 btn-block font-weight-bold p-0">[Ctrl+x] <br> Keluar</button>
        </div>
        
    </div>
</form>
<script src="{{asset('public/js/cashierButton.js')}}"></script>
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    const el_modal_all = $('.MODAL-CASHIER'),
                    el_modal_sm = $('#modal-global-sm'),
                    id_modal_content_cashier = '.MODAL-CONTENT-CASHIER',
                    url_cashier = "{{route('Cashier')}}";

    let t_Belanja = $("input[name=totalPayment]").val(),
        no_Struck = $("input[name=noStruck]").val(),
        idPelanggan = $("#pelanggan").find(":selected").val(),
        t_Bayar = $("input[name=tBayar]").val(),
        t_Selisih = $("input[name=tSelisih]").val(),
        t_Item = $("input[name=tItem]").val(),
        pengiriman = $("#pengiriman").find(":selected").val(),
        ppn = $("#ppn").find(":selected").val();
    
    $(function () {
        $('.select2').select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });

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
        else if (event.key === 'F6') {
            event.preventDefault();
            el_modal_sm.modal('show').find(id_modal_content_cashier).load(url_cashier + "/buttonAction/dataPenjualan");
        }
        else if (event.key === 'F7') {
            event.preventDefault();
            toastr.error('Tidak dapat menampilkan data, dikarenakan tidak ada nama pelanggan yang dipilih')
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
        else if (event.ctrlKey && event.key === 's') {
            event.preventDefault();            
            toastr.error('Tidak ada transaksi yang dapat di simpan !')
        }
        else if (event.ctrlKey && event.key === 'b') {
            event.preventDefault();
            let t_Bayar = $("#tBayar").val(),
                ppn = $("#ppn").val();
                ppnNominal = $("#nominalPPN").val();
                
            toastr.error('Tidak ada transaksi yang dapat dibayarkan !')
        }

    });
    $(document).ready(function(){
        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");

        $("#pelanggan").change(function(){
            idPelanggan = $(this).find(":selected").val();
            $.ajax({
                type : 'post',
                url : "{{route('Cashier')}}/buttonAction/postVariableData",
                data :  {t_Belanja:t_Belanja, no_Struck:no_Struck, pelanggan:idPelanggan, t_Bayar:t_Bayar, t_Selisih:t_Selisih, t_Item:t_Item, pengiriman:pengiriman, ppn:ppn},
                success : function(data){                
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);                    
                }
            }); 
        });
    });
</script>