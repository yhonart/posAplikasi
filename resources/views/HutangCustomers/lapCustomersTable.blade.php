<table class="table table-sm table-valign-middle" id="tableLapKreditCustomer">
    <thead>
        <tr>
            <th>Nama Customers</th>
            <th>No. Transaksi</th>
            <th class="text-right">Kredit</th>
            <th class="text-right">Sudah Dibayar</th>
            <th class="text-right">Sisa Kredit</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($dbTableKredit as $dbk)
            <tr>
                <td>{{$dbk->customer_store}}</td>
                <td>{{$dbk->from_payment_code}}</td>
                <td class="text-right">{{number_format($dbk->nominal,'0',',','.')}}</td>
                <td class="text-right">{{number_format($dbk->nom_payed,'0',',','.')}}</td>
                <td class="text-right">{{number_format($dbk->nom_kredit,'0',',','.')}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function(){        
        $("#tableLapKreditCustomer").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "searching": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>