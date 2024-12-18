<table class="table table-sm tabl-valign-middle">
    <thead>
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
                <td>{{$hf->debit}}</td>
                <td>{{$hf->kredit}}</td>
                <td>{{$hf->total_kredit}}</td>
            </tr>
        @endforeach
    </tbody>
</table>