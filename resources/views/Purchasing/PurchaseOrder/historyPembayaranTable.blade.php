<table class="table table-sm table-valign-middle" id="tableHistory">
    <thead class="bg-gray-dark">
        <tr>
            <th>Nomor</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Cara Pembayaran</th>
            <th>Total Kredit</th>
            <th>Pembayaran</th>
            <th>Saldo Kredit</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($disHistory as $dh)
            <tr>
                <td>{{$dh->nomor}}</td>
                <td>{{$dh->payment_date}}</td>
                <td>{{$dh->store_name}}</td>
                <td>{{$dh->methode}}</td>
                <td class="text-right">
                    <span class="font-weight-bold text-danger">{{number_format($dh->sub_total,'0',',','.')}}</span>
                </td>
                <td class="text-right">
                    <span class="font-weight-bold text-success">{{number_format($dh->kredit_pay,'0',',','.')}}</span>
                </td>
                <td class="text-right">
                    <span class="font-weight-bold text-info">
                        {{number_format($dh->selisih,'0',',','.')}}</td>
                    </span>
                <td>
                    <button type="button" class="btn btn-info btn-sm BTN-OPEN-MODAL-GLOBAL-LG" title="Detail" href="{{route('Purchasing')}}/historyPembayaran/detailPembayaran/{{$dh->idp_pay}}"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <a class="btn btn-primary btn-sm" href="#" target="_blank" title="Cetak" href="{{route('Purchasing')}}/historyPembayaran/cetakPembayaran/{{$dh->idp_pay}}"><i class="fa-solid fa-print"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>