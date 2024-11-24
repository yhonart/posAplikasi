<table class="table table-sm table-valign-middle table-hover">
    <thead class="font-weight-bold">
        <tr>
            <th>Kode Pembayaran</th>
            <th>Tgl. Pembayaran</th>
            <th>Total Kredit</th>
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
                <td class="text-right">{{number_format($lpc->total_kredit,'0',',','.')}}</td>
                <td class="text-right">{{number_format($lpc->debit,'0',',','.')}}</td>
                <td>{{$lpc->customer_store}}</td>
                <td>
                    <a href="{{route('Cashier')}}/dataPelunasan/printPelunasan/{{$lpc->payment_number}}" class="btn btn-sm btn-success" target="_blank">Cetak Voucher</a>
                    <button type="button" class="btn btn-sm btn-info edit-dokumen" id-number="{{$lpc->idtr_payment}}"><i class="fa-solid fa-pencil"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>