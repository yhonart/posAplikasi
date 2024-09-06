<table class="table table-bordered">
    <thead class="bg-purple">
        <tr>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Qty</th>
            <th>Hrg/Barang</th>
            <th>Jumlah</th>
            <th>Lokasi</th>
            <th>Stok Awal</th>
            <th>Stok Akhir</th>
        </tr>
    </thead>
    <tbody>
        @foreach($modalDetailBarang as $mdb2)
            <tr>
                <td>{{$mdb2->product_name}}</td>
                <td>{{$mdb2->satuan}}</td>
                <td>{{$mdb2->qty}}</td>
                <td class="text-right">{{number_format($mdb2->unit_price,'0',',','.')}}</td>
                <td class="text-right">{{number_format($mdb2->total_price,'0',',','.')}}</td>
                <td>{{$mdb2->site_name}}</td>
                <td>{{$mdb2->stock_awal}}</td>
                <td>{{$mdb2->stock_akhir}}</td>
            </tr>
        @endforeach
    </tbody>
</table>