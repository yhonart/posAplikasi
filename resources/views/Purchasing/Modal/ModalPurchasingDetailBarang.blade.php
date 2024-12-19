<table class="table table-sm table-valign-middle table-hover " id="detailPembelianBarang">
    <thead class="bg-gray-dark">
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
<script>
    $(function(){        
        $("#detailPembelianBarang").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>