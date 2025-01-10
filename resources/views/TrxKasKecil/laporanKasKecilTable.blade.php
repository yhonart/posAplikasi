<table class="table table-sm table-hover table-valign-mmiddle">
    <thead class="bg-gray-dark">
        <tr>
            <td>Tanggal</td>
            <td>Sub.Kategori</td>
            <td>Keterangan</td>
            <td>User</td>
            <td>Kredit</td>
            <td>Debit</td>
            <td>Saldo</td>
            <td>Ket. Lain</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($tablePengeluaran as $tbPengeluaran)
            <tr>
                <td>{{date("d-m-Y", strtotime($tbPengeluaran->kas_date))}}</td>
                <td>{{$tbPengeluaran->cat_name}} - {{$tbPengeluaran->subcat_name}}</td>
                <td>{{$tbPengeluaran->description}}</td>
                <td>{{$tbPengeluaran->kas_persCode}}#{{$tbPengeluaran->kas_persName}}</td>
                <td></td>
                <td>{{number_format($tbPengeluaran->nominal,'0',',','.')}}</td>
                <td></td>
                <td>{{$tbPengeluaran->file_name}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>