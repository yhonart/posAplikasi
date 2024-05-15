<div id="dataPaginate">
    <div class="row">
        <div class="col-6">
            <h5>Total : {{$productList->total()}}</h5>
        </div>
        <div class="col-6 text-right">
            {{$productList->links()}}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-valign-middle table-sm">
                <thead class="bg-gradient-purple">
                    <tr>
                        <th>Produk</th>
                        <th>SKU</th>
                        <th>Minimal Stock</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th><i class="fa-solid fa-bars"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productList as $pl)
                        <tr>
                            <td class="font-weight-bold">
                                @if($pl->file_name == "")
                                    <img src="{{asset('public/images/nope-not-here.webp')}}" alt="Product 1" class="img-size-50 mr-2">
    
                                @else
                                    <img src="{{asset('public/images/Upload/Product')}}/{{$pl->idm_data_product}}/{{$pl->file_name}}" alt="Product 1" class="img-size-50 mr-2">
    
                                @endif
                                {{$pl->product_name}}
                            </td>
                            <td>
                                {{$pl->sku}}
                            </td>
                            <td class="text-center">
                                {{$pl->minimum_stock}}
                            </td>
                            <td>
                                @foreach($prodUnit as $pu1)
                                    @if($pu1->core_id_product == $pl->idm_data_product)
                                    <dl class="row border-bottom mb-1 mt-1">
                                        <dt class="col-4">{{$pu1->product_size}}</dt>
                                        <dd class="col-8 text-success font-weight-bold">Rp.{{number_format($pu1->product_price_order)}}</dd>
                                    </dl>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($prodUnit as $pu2)
                                    @if($pu2->core_id_product == $pl->idm_data_product)
                                    <dl class="row border-bottom mb-1 mt-1">
                                        <dt class="col-4">{{$pu2->product_size}}</dt>
                                        <dd class="col-8 text-info font-weight-bold">Rp.{{number_format($pu2->product_price_sell)}}</dd>
                                    </dl>                                    
                                    @endif
                                @endforeach
                            </td>
                            <td class="text-right">
                                <div class="btn-group btn-sm">
                                    <button type="button" class="btn btn-default" data-toggle="dropdown">
                                        <i class="fa-solid fa-bars"></i>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Stock')}}/ProductMaintenance/MenuInventory/{{$pl->idm_data_product}}"><i class="fa-solid fa-boxes-stacked"></i> Edit Inventory</a>                                    
                                        <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('M_Manufacture')}}/arrayManufacture/editMenu/{{$pl->idm_data_product}}"><i class="fa-solid fa-arrows-to-eye"></i> Detail</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function ajaxPaging() {
        $('.pagination a').on('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#dataPaginate').load(url);
        });
    }
    ajaxPaging();
</script>