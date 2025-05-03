<?php
    $no = '1';
?>
<table class="table table-sm tabl-valign-middle table-hover" id="tableKreditCustomer">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Pelanggan</th>
            <th class=" bg-warning"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Limit Kredit</span></th>
            <th class=" bg-danger"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Total Hutang</span></th>
            <th class=" bg-success"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Total Dibayar</span></th>
            <th class=" bg-info"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Selisih Hutang</span></th>
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
            </tr>
        @endforeach
    </tbody>
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