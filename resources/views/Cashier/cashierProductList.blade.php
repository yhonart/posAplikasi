<p class="bg-danger p-1">Halaman ini sedang proses perbaikan 🙏</p>
<table id="myTable" border="1">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <tr data-id="1" data-nama="John Doe" data-email="john@example.com">
      <td>1</td>
      <td>John Doe</td>
      <td>john@example.com</td>
    </tr>
    <tr data-id="2" data-nama="Jane Smith" data-email="jane@example.com">
      <td>2</td>
      <td>Jane Smith</td>
      <td>jane@example.com</td>
    </tr>
    <tr data-id="3" data-nama="Peter Jones" data-email="peter@example.com">
      <td>3</td>
      <td>Peter Jones</td>
      <td>peter@example.com</td>
    </tr>
  </tbody>
</table>

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
            <tr data-id="idForm">
            <input type="hidden" name="transNumber" id="transNumber" value="{{$billNumber}}">
            <input type="hidden" name="prodName" id="prodName" autocomplete="off" list="browsers">
            <input type="hidden" name="prodNameHidden1" id="prodNameHidden1">
            <input type="hidden" name="hargaModal" id="hargaModal">
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
            searchData(keyword)                         
        }, 700)
        });

        function searchData(keyword){  
            // alert (keyword);
            let routeIndex = "{{route('Cashier')}}",
                urlProductList = "productList",
                panelProductList = $("#mainListProduct");
            if (keyword === '0' || keyword === '') {
                $("#tableSelectProduk").fadeOut("slow");
            }
            else{
                $("#tableSelectProduk").fadeIn("slow");
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
        }
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('myTable');
            const rows = table.getElementsByTagName('tr');
            let selectedRowIndex = -1;

            function selectRow(index) {
                if (selectedRowIndex >= 0) {
                    rows[selectedRowIndex].classList.remove('selected');
                }
                selectedRowIndex = index;
                if (selectedRowIndex >= 0) {
                    rows[selectedRowIndex].classList.add('selected');
                }
            }

            document.addEventListener('keydown', (event) => {
                if (event.key === 'ArrowDown') {
                    selectRow(Math.min(rows.length - 1, selectedRowIndex + 1));
                } else if (event.key === 'ArrowUp') {
                    selectRow(Math.max(0, selectedRowIndex - 1));
                } else if (event.key === 'Enter' && selectedRowIndex >= 0) {
                    const selectedRowData = rows[selectedRowIndex].innerText;
                    sendData(selectedRowData);
                }
            });

            function sendData(data) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/submit', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert('Data submitted: ' + data);
                    }
                };
                xhr.send(JSON.stringify({ rowData: data }));
            }
        });


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

</script>