<div class="row">
    <div class="col-md-12">
        <table class="table table-sm table-valign-middle table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Qty Order</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produkOrder as $por)
                    <tr>
                        <td>{{$por->product_name}}</td>
                        <td>{{$por->qty_order}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>