<style>
    dl dt:hover {
        background-color: rgba(0,0,0,.075);
    }
</style>
<div id="loadPaginate">
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
            <table class="table table-valign-middle table-bordered table-hover">
                <thead class="text-center bg-gradient-indigo">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Ukuran</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Margin</th>
                        <th>Stok</th>
                        <th><i class="fa-solid fa-bars"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productList as $pl)
                        <tr>
                            <td class="font-weight-bold">                                
                                {{$pl->product_name}}
                            </td>
                            <td>
                                <dl class="row p-0">
                                    @foreach($productPrice as $pp1)
                                        @if($pp1->core_id_product == $pl->idm_data_product)
                                        <dt class="col-12 border-bottom mt-1">{{$pp1->product_size}}</dt>
                                        @endif
                                    @endforeach
                                </dl>
                            </td>
                            <td class="text-right">
                                <dl class="row p-0">
                                    @foreach($productPrice as $pp2)
                                        @if($pp2->core_id_product == $pl->idm_data_product)
                                        <dt class="col-12 border-bottom mt-1">{{number_format($pp2->product_price_order, 0, ',', '.')}}</dt>
                                        @endif
                                    @endforeach
                                </dl>
                            </td>
                            <td class="text-right">
                                <dl class="row p-0">
                                    @foreach($productPrice as $pp3)
                                        @if($pp3->core_id_product == $pl->idm_data_product)
                                        <dt class="col-12 border-bottom mt-1">{{number_format($pp3->product_price_sell, 0, ',', '.')}}</dt>
                                        @endif
                                    @endforeach
                                </dl>
                            </td>
                            <td class="text-right">
                                <dl class="row p-0">
                                    @foreach($productPrice as $pp4)
                                        @if($pp4->core_id_product == $pl->idm_data_product)
                                            <?php
                                                $margin = $pp4->product_price_sell - $pp4->product_price_order;
                                            ?>
                                        <dt class="col-12 border-bottom mt-1">{{number_format($margin, 0, ',', '.')}}</dt>
                                        @endif
                                    @endforeach
                                </dl>
                            </td>
                            <td class="text-right">
                                <dl class="row p-0">
                                    @foreach($productPrice as $pp5)
                                        @if($pp5->core_id_product == $pl->idm_data_product) 
                                            @if($pp5->stock == "" OR $pp5->stock==NULL)  
                                                <dt class="col-12 border-bottom mt-1">0</dt>                                            
                                            @else
                                                <dt class="col-12 border-bottom mt-1">{{$pp5->stock}}</dt>
                                            @endif
                                        @endif
                                    @endforeach
                                </dl>
                            </td>
                                                     
                            <td class="text-right">
                                <div class="btn-group btn-sm">
                                    <button type="button" class="btn btn-info elevation-1" data-toggle="dropdown">
                                        <i class="fa-solid fa-bars"></i>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Stock')}}/ProductMaintenance/MenuPriceEdit/{{$pl->idm_data_product}}"><i class="fa-solid fa-rupiah-sign"></i> Edit Harga & Stok</a>                                    
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
            $('#loadPaginate').load(url);
        });
    }
    ajaxPaging();
</script>