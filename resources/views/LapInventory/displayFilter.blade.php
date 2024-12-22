<?php
    $saldo = 0;
    $tMasuk = 0;
    $tKeluar = 0;
    $tSaldo = 0;
?>
<div class="row">
    <div class="col-12">
        <div class="card card-body table-responsive" style="height:700px;">
            <table class="table table-valign-middle table-hover" id="tableDisplayLap">
                <thead class="bg-gray-dark">
                    <tr>
                        <th>Tanggal </th>
                        <th>Nomor Bukti</th>
                        <th>Product</th>
                        <th>Keterangan</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   
                        $saldoawal = 0; 
                        $saldoHitung = 0;                       
                        if ($codeDisplay == '1' AND !empty($dataSaldoAwal)) {
                            echo "<tr>";
                                echo "<td>".$dataSaldoAwal->date_input."</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>Saldo Awal</td>";
                                echo "<td class='text-right'>0</td>";
                                echo "<td class='text-right'>0</td>";
                                echo "<td class='text-right'>";

                                if ($dataSaldoAwal->inv_in == '0') {
                                    $saldoawal = $dataSaldoAwal->saldo + $dataSaldoAwal->inv_out;
                                }
                                else {
                                    $saldoawal = $dataSaldoAwal->saldo - $dataSaldoAwal->inv_in;
                                }

                                if ($mProduct->medium_unit_val == '0') {
                                    $awal = $saldoawal;
                                }
                                elseif ($mProduct->small_unit_val == '0') {
                                    $awal = $saldoawal * $mProduct->medium_unit_val;
                                }
                                else {
                                    $awal = $saldoawal * $mProduct->small_unit_val;
                                }
                                echo $saldoawal;
                                echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                    @foreach($dataReportInv as $dri)
                        <tr>
                            <td>{{$dri->date_input}}</td>
                            <td>{{$dri->number_code}}</td>
                            <td>{{$dri->product_name}}</td>
                            <td>{{$dri->description}}</td>
                            <td class="text-right">{{$dri->inv_in}}</td>
                            <td class="text-right">{{$dri->inv_out}}</td>
                            <td class="text-right">
                                <?php
                                    $saldo += $dri->inv_in - $dri->inv_out;
                                    $tMasuk += $dri->inv_in;
                                    $tKeluar += $dri->inv_out;
                                    $tSaldo += $dri->saldo;
                                ?>
                                {{$saldo}}
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="4" class="font-weight-bold text-center bg-lightblue">TOTAL</td>
                            <td class="font-weight-bold text-right bg-lightblue">{{$tMasuk}}</td>
                            <td class="font-weight-bold text-right bg-lightblue">{{$tKeluar}}</td>
                            <td class="bg-lightblue">{{$tSaldo}}</td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
