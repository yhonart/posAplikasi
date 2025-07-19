<div class="row">
    <div class="col-md-12">
        <table class="table table-sm table-valign-middle table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Customer</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Tgl.Kirim</th>
                    <th>Waktu.Kirim</th>
                    <th>Pengirim</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveryRecept as $dr)
                    <tr>
                        <td>{{$dr->delivery_number}}</td>
                        <td>{{$dr->customer_store}}</td>
                        <td></td>
                        <td></td>
                        <td>{{$dr->delivery_date}}</td>
                        <td>{{$dr->delivery_time}}</td>
                        <td>{{$dr->created_by}}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>