<?php
    $hitungBayar = '0';
    $numberRow = '1';
?>
<table width="100%" border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nominal</th>
            <th>Dibayar</th>
            <th>Sisa Hutang</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($hutang as $h)
            <tr>
                <td>{{$h->from_payment_code}}</td>
                <td>{{$h->nominal}}</td>
                <td>{{$h->nom_payed}}</td>
                <td>
                    <?php
                        $hitungBayar = $h->nom_kredit - $nominalBayar;
                    ?>
                    {{$hitungBayar}}
                </td>
                <td>
                    <?php
                        if ($hitungBayar < '0') {
                            foreach ($hutang as $h1) {
                                if ($h1->idtr_kredit <> $h->idtr_kredit) {
                                    $hutangKedua = $h1->nom_kredit - $hutang;
                                    echo $hutangKedua;
                                }
                            }
                        }
                    ?>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>