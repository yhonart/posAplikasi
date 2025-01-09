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
        @foreach($tablePengeluaran as $tbPengeluaran)
            <tr>
                <td>{{$tbPengeluaran->kas_date}}</td>
                <td>
                    <?php
                        $dateTk = date("dmy", strtotime($tbPengeluaran->kas_date));
                        $idTk = $tbPengeluaran->idtr_kas;
                        $noTrx = "KAS" . $dateTk . "-" . sprintf("%07d", $idTk);
                    ?>
                    {{$noTrx}}
                </td>
                <td>{{$tbPengeluaran->kas_persCode}}#{{$tbPengeluaran->kas_persName}}</td>
                <td>{{$tbPengeluaran->cat_name}} <br> {{$tbPengeluaran->subcat_name}}</td>
                <td>{{number_format($tbPengeluaran->nominal,'0',',','.')}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>