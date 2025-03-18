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
            <td>
                <select name="produk" id="produk" class="form-control form-control-sm">
                    <option value="0"> === </option>
                    @foreach($listProduk as $lp)
                        <option value="{{$lp->productID}}">{{$lp->product_name}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
    </tbody>
</table>