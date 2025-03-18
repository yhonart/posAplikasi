<table class="table table-sm table-valign-middle text-nowrap">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>WH</th>
            <th>Hrg.Satuan</th>
            <th>Point</th>
            <th>Stock Awal</th>
            <th>Stock Akhir</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#</td>
            <td>
                <select name="produk" id="produk" class="form-control form-control-sm">
                    <option value="0"> === </option>
                    @foreach($listProduk as $lp)
                        <option value="{{$lp->productID}}">{{$lp->product_name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="qty" id="qty" class="form_control form-control-sm form-control-border">
            </td>
            <td>
                <select name="satuan" id="satuan" class="form-control form-control-sm form-control-border">
                    <option value="0"> === </option>
                </select>
            </td>
            <td>
                <select name="warehouse" id="warehouse" class="form-control form-control-sm form-control-border">
                    <option value="0"> === </option>
                </select>
            </td>
            <td>
                <input type="text" name="hrgSatuan" id="hrgSatuan" class="form_control form-control-sm form-control-border">
            </td>
            <td>
                <input type="text" name="point" id="point" class="form_control form-control-sm form-control-border">
            </td>
            <td>
                <input type="text" name="stockAwal" id="stockAwal" class="form_control form-control-sm form-control-border">
            </td>
            <td>
                <input type="text" name="stockAkhir" id="stockAkhir" class="form_control form-control-sm form-control-border">
            </td>
            <td>
                <input type="text" name="keterangan" id="keterangan" class="form_control form-control-sm form-control-border">
            </td>
            <td>
                
            </td>
        </tr>
    </tbody>
</table>