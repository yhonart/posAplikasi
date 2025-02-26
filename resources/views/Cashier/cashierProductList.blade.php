<!--<p class="bg-danger p-1">Halaman ini sedang proses perbaikan 🙏</p>-->
<table class="table table-sm table-valign-middle table-head-fixed table-hover table-bordered" id="listTableItemTrx">
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
        

        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('listTableItemTrx');
            const rows = table.querySelectorAll('tbody tr');
            let selectedRowIndex = -1;

            // Fungsi untuk menandai baris yang dipilih
            function selectRow(index) {
                if (selectedRowIndex !== -1) {
                rows[selectedRowIndex].classList.remove('selected');
                }
                if (index >= 0 && index < rows.length) {
                rows[index].classList.add('selected');
                selectedRowIndex = index;
                }
            }

            // Event listener untuk tombol panah atas dan bawah
            document.addEventListener('keydown', function(event) {
                if (event.key === 'ArrowDown') {
                event.preventDefault(); // Mencegah scroll halaman
                if (selectedRowIndex < rows.length - 1) {
                    selectRow(selectedRowIndex + 1);
                }
                } else if (event.key === 'ArrowUp') {
                event.preventDefault(); // Mencegah scroll halaman
                if (selectedRowIndex > 0) {
                    selectRow(selectedRowIndex - 1);
                }
                } else if (event.key === 'Enter' && selectedRowIndex !== -1) {
                    // Kirim data menggunakan AJAX
                    const selectedRow = rows[selectedRowIndex];
                    const id = selectedRow.dataset.id;
                    alert (id);
                    // Contoh penggunaan fetch API
                    // fetch('/proses_data', { // Ganti dengan URL endpoint Anda
                    //     method: 'POST',
                    //     headers: {
                    //     'Content-Type': 'application/json',
                    //     },
                    //     body: JSON.stringify({ id: id, nama: nama, email: email }),
                    // })
                    // .then(response => response.json())
                    // .then(data => {
                    //     console.log('Sukses:', data);
                    //     // Lakukan sesuatu dengan respons dari server
                    // })
                    // .catch((error) => {
                    //     console.error('Error:', error);
                    // });
                }
            });

            // Styling untuk baris yang dipilih (opsional)
            const style = document.createElement('style');
            style.innerHTML = `
                #myTable tbody tr.selected {
                background-color: #f0f0f0;
                }
            `;
            document.head.appendChild(style);
            });
    });

</script>