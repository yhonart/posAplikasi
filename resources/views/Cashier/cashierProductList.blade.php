<!--<p class="bg-danger p-1">Halaman ini sedang proses perbaikan 🙏</p>-->
<table class="table table-sm table-valign-middle table-head-fixed table-hover table-bordered" id="mainTablePrdList">
    <thead class="text-center">
        <tr>
            <th width="5%">No</th>
            <th width="20%">Nama Barang [F3]</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Hrg. Satuan</th>
            <th>Disc</th>
            <th>Jumlah</th>
            <th>Stock</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="trLoadProduct"></tbody>
    <tbody id="trInputProdut">
        <form id="formInputBarangKasir">            
            <input type="hidden" name="transNumber" id="transNumber" value="{{$billNumber}}">
            <input type="hidden" name="prodName" id="prodName" autocomplete="off" list="browsers">
            <input type="hidden" name="prodNameHidden1" id="prodNameHidden1">
            <input type="hidden" name="hargaModal" id="hargaModal">
            <tr>
                <td colspan="2" class="p-0">
                    <input type="text" class="form-control form-control-sm form-control-border border-width-2" name="fieldProduk" id="fieldProduk" placeholder="Scan Barcode Disini" autocomplete="off">
                </td>
                <td class="p-0">
                    <input type="number" name="formQty" id="formQty" class="form-control form-control-sm form-control-border border-width-2" autocomplete="off" readonly>
                </td>
                <td class="p-0">
                    <select name="formSatuan" id="formSatuan" class="form-control  form-control-sm form-control-border border-width-2" readonly>
                        <option value="0"></option>
                    </select>
                </td>
                <td class="p-0">
                    <input type="text" name="formHargaSatuan" id="formHargaSatuan" class="form-control form-control-sm form-control-border border-width-2" readonly>
                </td>
                <td class="p-0">
                    <input type="text" name="formDisc" id="formDisc" class="form-control form-control-sm form-control-border border-width-2" autocomplete="off" readonly>
                </td>
                <td class="p-0">
                    <input type="text" name="formJumlah" id="formJumlah" class="form-control form-control-sm form-control-border border-width-2" readonly>
                </td>
                <td class="p-0" colspan="2">
                    <input type="hidden" name="formStockHidden" id="formStockHidden" class="form-control  form-control-sm" readonly>
                    <input type="text" name="formStock" id="formStock" class="form-control form-control-sm form-control-border border-width-2" readonly>
                </td>
            </tr>
        </form>
    </tbody>
    <tbody id="tableSelectProduk"></tbody>
</table>
<script type="text/javascript">
     $(function () {   
        $("#fieldProduk").val(null).focus();        
    });   
    $(document).ready(function() {
        let keyword = '0',
        timer_cari_equipment = null,
        trxNumber = "{{$billNumber}}";
        
        loadTableData(trxNumber);

        $("#fieldProduk").keyup(function (e) {
            e.preventDefault();
            clearTimeout(timer_cari_equipment); 
            timer_cari_equipment = setTimeout(function(){                
                let keyword = $("#fieldProduk").val().trim();
                if(keyword == ''){
                    keyword = '0';
                }
            if (keyword !== '0') {
                $("#tableSelectProduk").fadeIn("slow");
                searchData(keyword)
            }
            else{
                $("#tableSelectProduk").fadeOut("slow");
            }               
        }, 700)
        });

        function searchData(keyword){  
            // alert (keyword);
            let routeIndex = "{{route('Cashier')}}",
                urlProductList = "productList",
                panelProductList = $("#mainListProduct");

            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/cariProduk/"+keyword+"/"+trxNumber,
                success : function(response){
                    if (response.warningCustomer) {
                        alertify
                        .alert(response.warningCustomer, function(){
                            alertify.message('OK');
                            window.location.reload();
                        }).set({title:"Alert !"});
                    }
                    else if(response.success){
                        $("#fieldProduk").val('');
                        loadTableData(trxNumber);
                        totalBelanja(trxNumber);
                        alertify.success(response.success);
                    }
                    else{
                        $("#tableSelectProduk").html(response);                        
                    }
                }
            });
        }
        
        function loadTableData(trxNumber){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/listTableTransaksi/"+trxNumber,
                success : function(response){                
                    $("#trLoadProduct").html(response);
                }
            });
        }

        function totalBelanja(trxNumber){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/updateTotalBeanja/"+trxNumber,
                success : function(response){
                    $('#totalBelanja').html(response);
                }
            });
        }
    });

    // Ambil elemen tabel
    const table = document.getElementById('mainTablePrdList');

    // Inisialisasi indeks baris yang dipilih
    let selectedRowIndex = -1;

    // Tambahkan event listener untuk tombol panah atas dan bawah
    document.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowDown') {
        // Pilih baris berikutnya
        if (selectedRowIndex < table.rows.length - 1) {
        selectedRowIndex++;
        selectRow(selectedRowIndex);
        }
    } else if (event.key === 'ArrowUp') {
        // Pilih baris sebelumnya
        if (selectedRowIndex > 0) {
        selectedRowIndex--;
        selectRow(selectedRowIndex);
        }
    } else if (event.key === 'Enter') {
        // Input data pada baris yang dipilih
        if (selectedRowIndex !== -1) {
        inputData(selectedRowIndex);
        }
    }
    });

    // Fungsi untuk memilih baris
    function selectRow(index) {
    // Hapus kelas 'selected' dari baris sebelumnya
    const selectedRow = document.querySelector('.selected');
    if (selectedRow) {
        selectedRow.classList.remove('selected');
    }

    // Tambahkan kelas 'selected' ke baris yang dipilih
    table.rows[index].classList.add('selected');
    }

    // Fungsi untuk input data
    function inputData(index) {
    // Ambil data dari baris yang dipilih
    const row = table.rows[index];
    const cells = row.cells;

    // Misalnya, tampilkan data dalam alert
    let data = '';
    for (let i = 0; i < cells.length; i++) {
        data += cells[i].textContent + ' ';
    }
    alert('Data baris yang dipilih: ' + data);

    // Anda dapat mengganti alert dengan logika input data Anda sendiri
    // Misalnya, menampilkan modal atau form untuk mengedit data
    }
</script>