<div id="dataPaginate">
    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-valign-middle table-sm">
                <thead class="bg-gray">
                    <tr>
                        <th>Produk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productList as $pl)
                        <tr>
                            <td class="font-weight-bold">
                                <a class="DETAIL-PRODUCT text-navy" href="#">
                                   
                                    {{$pl->product_name}}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <small>Total : {{$productList->total()}}</small>
        </div>
        <div class="col-6 text-right">
            <small>{{$productList->links()}}</small>
        </div>
    </div>
</div>