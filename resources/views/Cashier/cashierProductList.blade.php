<!--<p class="bg-danger p-1">Halaman ini sedang proses perbaikan 🙏</p>-->
<table class="table table-sm table-valign-middle table-head-fixed table-hover " id="mainTablePrdList">
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
                    <input type="search" class="form-control form-control-sm form-control-border border-width-2" name="fieldProduk" id="fieldProduk" placeholder="Scan Barcode Disini">
                </td>
                <td class="p-0">
                    <input type="number" name="qty" id="qty" class="form-control form-control-sm form-control-border border-width-2" autocomplete="off" readonly>
                </td>
                <td class="p-0">
                    <select name="satuan" id="satuan" class="form-control  form-control-sm form-control-border border-width-2">
                        <option value="0"></option>
                    </select>
                </td>
                <td class="p-0">
                    <input type="text" name="hargaSatuan" id="hargaSatuan" class="form-control  price-text prd-input form-control-sm" readonly>
                </td>
                <td class="p-0">
                    <input type="text" name="disc" id="disc" class="form-control  prd-input form-control-sm" autocomplete="off">
                </td>
                <td class="p-0">
                    <input type="text" name="jumlah" id="jumlah" class="form-control  prd-input form-control-sm" readonly>
                </td>
                <td class="p-0">
                    <input type="hidden" name="stockHidden" id="stockHidden" class="form-control  form-control-sm" readonly>
                    <input type="text" name="stock" id="stock" class="form-control  prd-input form-control-sm" readonly>
                </td>
                <td>
                    
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
</script>