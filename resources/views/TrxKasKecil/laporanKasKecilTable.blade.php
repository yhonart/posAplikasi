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
                <td>
                    <?php
                        $dateTk = date("dmy", strtotime($pengeluaran->kas_date));
                        $idTk = $pengeluaran->idtr_kas;
                        $noTrx = "KAS" . $dateTk . "-" . sprintf("%07d", $idTk);
                    ?>
                    {{$noTrx}}
                </td>
                <td>{{$pengeluaran->kas_persCode}}#{{$pengeluaran->kas_persName}}</td>
                <td>{{$pengeluaran->cat_name}} <br> {{$pengeluaran->subcat_name}}</td>
                <td>{{number_format($pengeluaran->nominal,'0',',','.')}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>