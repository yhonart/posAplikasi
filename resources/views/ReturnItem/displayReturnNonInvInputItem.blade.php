<table class="table table-sm table-valign-middle text-nowrap">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>WH</th>
            <th>Satuan</th>
            <th>Qty</th>
            <th>Hrg.Satuan</th>
            <th>Point</th>
            <th>Stock Awal</th>
            <th>Stock Akhir</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                #
                <input type="hidden" name="idLo" id="idLo">
                <input type="hidden" name="recive" id="recive">
                <input type="hidden" name="unit" id="unit">
                <input type="hidden" name="hiddenProdukID" id="hiddenProdukID">
            </td>
            <td>
                <select name="produk" id="produk" class="form-control form-control-sm">
                    <option value="0"> === </option>
                    @foreach($listProduk as $lp)
                        <option value="{{$lp->productID}}">{{$lp->product_name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="warehouse" id="warehouse" class="form-control form-control-sm form-control-border">
                    <option value="0">  </option>
                    @foreach($warehouse as $wh)
                        <option value="{{$wh->idm_site}}">{{$wh->site_name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="satuan" id="satuan" class="form-control form-control-sm form-control-border">
                    <option value="0"> === </option>
                </select>
            </td>
            <td>
                <input type="number" name="qty" id="qty" class="form-control form-control-sm form-control-border">
            </td>            
            <td>
                <input type="text" name="hrgSatuan" id="hrgSatuan" class="form-control form-control-sm form-control-border">
            </td>
            <td>
                <input type="text" name="point" id="point" class="form-control form-control-sm form-control-border">
            </td>
            <td>
                <input type="text" name="stockAwal" id="stockAwal" class="form-control form-control-sm form-control-border">
            </td>
            <td>
                <input type="text" name="stockAkhir" id="stockAkhir" class="form-control form-control-sm form-control-border">
            </td>
            <td>
                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm form-control-border">
            </td>
        </tr>
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $("#produk").focus();
        let qtyBeli = document.getElementById("qty"),
            satuan = document.getElementById("satuan");
        
        $("#produk").change(function(){
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('returnItem')}}/productAction/" + productID,
                success : function(response){  
                    $("#satuan").html(response).focus();
                }
            });
        });

        satuan.addEventListener("change", function(){
            
        });
    });
</script>