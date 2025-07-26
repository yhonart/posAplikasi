<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title font-weight-normal">History Delivery</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-sm table-valign-middle text-xs">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Pelanggan</th>
                    <th>Produk-Qty</th>
                    <th>Tgl. Kirim</th>
                    <th>Waktu. Kirim</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($trxDelivery as $tdl)
                    <tr>
                        <td>{{$tdl->delivery_number}}</td>
                        <td>{{$tdl->delivery_number}}</td>
                        <td></td>
                        <td>{{$tdl->delivery_date}}</td>
                        <td>{{$tdl->delivery_time}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>