<table class="table table-sm table-valign-middle table-hover">
    <thead class="font-weight-bold">
        <tr>
            <th>Kode Pembayaran</th>
            <th>Tgl. Pembayaran</th>
            <th>Nominal Pembayaran</th>
            <th>Nama Pelanggan</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listPembayaranCustomer as $lpc)
            <tr>
                <td>{{$lpc->payment_number}}</td>
                <td>{{$lpc->date_payment}}</td>
                <td>{{$lpc->debit}}</td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>