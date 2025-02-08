<?php
    $saldo = 0;
    $tMasuk = 0;
    $tKeluar = 0;
    $tSaldo = 0;
    $disSaldo = 0;
    $keyMasuk = 0;
    $keyKeluar = 0;
    $keySaldo = 0;
    $saldo1 = 0;
    $saldo2 = 0;
    $saldo3 = 0;
    if (!empty($lastSaldo)) {
        $saldoInv = $lastSaldo->stock;
    }
    else {
        $saldoInv = 0;
    }
    foreach ($dataReportInv as $keyReport) {
        $keyMasuk += $keyReport->inv_in;
        $keyKeluar += $keyReport->inv_out;
        $keySaldo += $keyMasuk - $keyKeluar;
    }
?>
<div class="row">
    <div class="col-12">
        <div class="card card-body table-responsive" style="height:700px;">
            @if($codeDisplay == '1')
                <!-- display table menggunakan filtering data  -->
                <table class="table table-valign-middle table-hover" id="tableDisplayLap">
                    <thead class="bg-gray-dark">
                        <tr>
                            <th>Tanggal</th>
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
                            if (!empty($dataSaldoAwal)) {
                                echo "<tr>";
                                    echo "<td class='font-weight-bold'>".$dataSaldoAwal->date_input."</td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td class='font-weight-bold'>Saldo Awal</td>";
                                    echo "<td class='text-right font-weight-bold'>0</td>";
                                    echo "<td class='text-right font-weight-bold'>0</td>";
                                    echo "<td class='text-right font-weight-bold'>";
    
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
                                <td class="text-right">{{number_format($dri->inv_in,'0',',','.')}}</td>
                                <td class="text-right">{{number_format($dri->inv_out,'0',',','.')}}</td>
                                <td class="text-right">
                                    <?php
                                        $saldo += $dri->inv_in - $dri->inv_out;
                                        $tMasuk += $dri->inv_in;
                                        $tKeluar += $dri->inv_out;                                    
                                    ?>
                                    {{number_format($dri->saldo,'0',',','.')}}
                                </td>
                            </tr>
                        @endforeach
                            <tr>
                                <td colspan="4" class="font-weight-bold text-center bg-lightblue">TOTAL</td>
                                <td class="font-weight-bold text-right bg-lightblue">{{number_format($tMasuk,'0',',','.')}}</td>
                                <td class="font-weight-bold text-right bg-lightblue">{{number_format($tKeluar,'0',',','.')}}</td>
                                <td class="bg-lightblue"></td>
                            </tr>
                    </tbody>
                </table>
            @else
                <div class="blue-alert rounded mb-2 p-4">
                    <span class="font-weight-bold"><i class="fa-solid fa-circle-info"></i> Secara default, data yang di tampilkan adalah transaksi data hari ini. Silahkan gunakan filter data untuk menampilkan per item.</span>
                </div>
                <table class="table table-valign-middle table-hover">
                    <thead class="bg-gray-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nomor Bukti</th>
                            <th>Product</th>
                            <th>Keterangan</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataReportInv as $dri)
                            <tr>
                                <td>{{$dri->date_input}}</td>
                                <td>{{$dri->number_code}}</td>
                                <td>{{$dri->product_name}}</td>
                                <td>{{$dri->description}}</td>
                                <td class="text-right">{{number_format($dri->inv_in,'0',',','.')}}</td>
                                <td class="text-right">{{number_format($dri->inv_out,'0',',','.')}}</td>                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif            
        </div>
    </div>
</div>
<script>
    $(function(){        
        $("#tableDisplayLap").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "searching": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
