<?php
    $no = '1';
    $sumLimit = '0';
    $sumNKredit = '0';
    $sumNBayar = '0';
    $sumSisaKredit = '0';
?>
<table class="table table-sm tabl-valign-middle table-hover" id="tableKreditCustomer">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Pelanggan</th>
            <th class=" bg-warning"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Limit Kredit</span></th>
            <th class=" bg-danger"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Nilai Kredit</span></th>
            <th class=" bg-success"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Nilai Bayar</span></th>
            <th class=" bg-info"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Sisa Kredit</span></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($sumSaldoCustomer as $ssc)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$ssc->customer_store}}</td>
                <td class="text-right bg-warning">{{number_format($ssc->kredit_limit,'0',',','.')}}</td>
                <td class="text-right bg-danger">{{number_format($ssc->nominal,'0',',','.')}}</td>
                <td class="text-right bg-success">{{number_format($ssc->nomPayed,'0',',','.')}}</td>
                <td class="text-right bg-info">{{number_format($ssc->saldoKredit,'0',',','.')}}</td>
                <td>
                    <a href="#" target="_blank" class="btn btn-sm btn-info"><i class="fa-solid fa-eye"></i></a>
                </td>
            </tr>
            <?php
                $sumLimit += $ssc->kredit_limit;
                $sumNKredit += $ssc->nominal;
                $sumNBayar += $ssc->nomPayed;
                $sumSisaKredit += $ssc->saldoKredit;
            ?>
        @endforeach        
    </tbody>
    <tfoot class=" bg-gray-light">
        <tr>
            <th></th>
            <th class="text-right">Sub Total</th>
            <td class="text-right"></td>
            <td class="text-right">{{number_format($sumNKredit,'0',',','.')}}</td>
            <td class="text-right">{{number_format($sumNBayar,'0',',','.')}}</td>
            <td class="text-right">{{number_format($sumSisaKredit,'0',',','.')}}</td>
            <td></td>
        </tr>
    </tfoot>
</table>
<script>
    $(function(){        
        $("#tableKreditCustomer").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "searching": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>