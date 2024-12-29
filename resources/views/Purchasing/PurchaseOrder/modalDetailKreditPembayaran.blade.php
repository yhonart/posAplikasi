<table class="table tabl-sm table-hover table-calign-middle">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Tgl. Pembayaran</th>
            <th>Metode Pembayaran</th>
            <th>Bank Account</th>
            <th>Bank Number</th>
            <th>Nominal Bayar</th>
            <th>Saldo Hutang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tbPembayaran as $pay)
            <tr>
                <td>{{$pay->nomor}}</td>
                <td>{{$pay->payment_date}}</td>
                <td>{{$pay->methode}}</td>
                <td>{{$pay->account}}</td>
                <td>{{$pay->number_account}}</td>
                <td class="text-right"><span class="text-success font-weight-bold">{{number_format($pay->kredit_pay,'0',',','.')}}</span></td>
                <td class="text-right"><span class="text-success font-weight-bold">{{number_format($pay->selisih,'0',',','.')}}</span></td>
            </tr>
        @endforeach
    </tbody>
</table>