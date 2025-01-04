<table class="table table-sm tabl-valign-middle table-hover" id="tableKreditFaktur">
    <thead class="bg-gray-dark">
        <tr>
            <th>Nomor</th>
            <th>Tgl. Pembayaran</th>
            <th>Pelanggan</th>
            <th>No.Perkiraan</th>
            <th>No.Kredit</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($historyFaktur as $hf)
            <tr>
                <td>{{$hf->payment_number}}</td>
                <td>{{$hf->date_payment}}</td>
                <td>{{$hf->customer_store}}</td>
                <td>{{$hf->account_code}} | {{$hf->account_name}}</td>
                <td>{{$hf->no_kredit}}</td>
                <td class="text-right">{{number_format($hf->debit,'0',',','.')}}</td>
                <td class="text-right">{{number_format($hf->kredit,'0',',','.')}}</td>
                <td class="text-right">{{number_format($hf->total_kredit,'0',',','.')}}</td>
                <td>
                    <a href="{{route('Cashier')}}/dataPelunasan/printPelunasan/{{$hf->payment_number}}" class="btn btn-primary btn-sm"><i class="fa-solid fa-print"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function(){        
        $("#tableKreditFaktur").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "searching": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>