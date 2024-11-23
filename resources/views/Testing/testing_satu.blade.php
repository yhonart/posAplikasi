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
                        $disrow = $numberRow++;
                        $hitungBayar = $h->nom_kredit - $nominalBayar;
                        if ($disrow > 1) {
                            $hitungBayar = $hitungBayar - $h->nom_kredit;
                        }
                    ?>
                    {{$disrow}} - {{$hitungBayar}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>