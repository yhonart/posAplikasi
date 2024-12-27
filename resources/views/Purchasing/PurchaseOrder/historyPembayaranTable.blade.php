<table class="table table-sm table-valign-middle" id="tableHistory">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Tanggal</th>
            <th>Type Pembayaran</th>
            <th>Bayar</th>
            <th>Saldo Kredit</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($disHistory as $dh)
            <tr>
                <td>{{$dh->nomor}}</td>
                <td>{{$dh->payment_date}}</td>
                <td>{{$dh->methode}}</td>
                <td>{{number_format($dh->kredit_pay,'0',',','.')}}</td>
                <td>{{number_format($dh->selisih,'0',',','.')}}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm BTN-OPEN-MODAL-GLOBAL-LG"><i class="fa-solid fa-magnifying-glass"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>