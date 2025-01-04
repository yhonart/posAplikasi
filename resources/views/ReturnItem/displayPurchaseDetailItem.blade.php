<div class="row">
    <div class="col-md-12">
        <div class="card card-body">
            <table class="table table-sm table-valign-middle table-hover">
                <thead class="bg-gray-dark">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Qty</th>
                        <th class="text-right">Hrg. Satuan</th>
                        <th class="text-right">Total</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viewPurchaseOrder as $item)
                        <tr>
                            <td>{{$item->product_name}}</td>
                            <td>{{$item->satuan}}</td>
                            <td>{{$item->qty}}</td>
                            <td class="text-right">{{number_format($item->unit_price,'0',',','.')}}</td>
                            <td class="text-right">{{number_format($item->total_price,'0',',','.')}}</td>
                            <td>{{$item->site_name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>