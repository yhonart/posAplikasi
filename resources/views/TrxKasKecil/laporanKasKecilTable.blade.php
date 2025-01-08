<table class="table table-sm table-hover table-valign-mmiddle">
    <thead class="bg-gray-dark">
        <tr>
            <td>Tanggal</td>
            <td>Nomor</td>
            <td>Penerima</td>
            <td>Kategori/Sub.Kategori</td>
            <td>Total</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($tablePengeluaran as $pengeluaran)
            <tr>
                <td>{{$pengeluaran->kas_date}}</td>
                <td>{{$pengeluaran->kas_number}}</td>
                <td>{{$pengeluaran->kas_persCode}}#{{$pengeluaran->kas_persName}}</td>
                <td>{{$pengeluaran->cat_name}} <br> {{$pengeluaran->subcat_name}}</td>
                <td>{{number_format($pengeluaran->nominal,'0',',','.')}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>