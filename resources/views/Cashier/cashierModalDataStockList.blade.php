<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
        <thead class="bg-indigo">
            <tr>
                <td>Nama Produk</td>
                @foreach($headerSize as $headS1)
                    <td>Hrg.{{$headS1->product_size}}</td>
                @endforeach
                @foreach($headerSize as $headS2)
                    <td>HrgJual.{{$headS2->product_size}}</td>
                @endforeach
                <td>Stock</td>
            </tr>
        </thead>
        <tbody>
            @foreach($productList as $pL)
                <tr>
                    <td>{{$pL->product_name}}</td>
                    <td class="text-right">
                        @foreach($productUnitList as $pul1)
                            @if($pul1->core_id_product==$pL->idm_data_product AND $pul1->product_size=="Besar")
                                <span class="check-number">{{$pul1->product_price_order}}</span>
                            @endif
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($productUnitList as $pul2)
                            @if($pul2->core_id_product==$pL->idm_data_product AND $pul2->product_size=="Kecil")
                                <span class="check-number">{{$pul2->product_price_order}}</span>
                            @endif
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($productUnitList as $pul3)
                            @if($pul3->core_id_product==$pL->idm_data_product AND $pul3->product_size=="Terkecil")
                                <span class="check-number">{{$pul3->product_price_order}}</span>
                            @endif
                        @endforeach
                    </td>
                    <!-- Harga Jual  -->
                    <td class="text-right">
                        @foreach($productUnitList as $pul4)
                            @if($pul4->core_id_product==$pL->idm_data_product AND $pul4->product_size=="Besar")
                                <span class="check-number">{{$pul4->product_price_sell}}</span>
                            @endif
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($productUnitList as $pul5)
                            @if($pul5->core_id_product==$pL->idm_data_product AND $pul5->product_size=="Kecil")
                                <span class="check-number">{{$pul5->product_price_sell}}</span>
                            @endif
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($productUnitList as $pul6)
                            @if($pul6->core_id_product==$pL->idm_data_product AND $pul6->product_size=="Terkecil")
                                <span class="check-number">{{$pul6->product_price_sell}}</span>
                            @endif
                        @endforeach
                    </td>
                    <!-- stock  -->
                    <td class="text-right">
                        @foreach($productUnitList as $pul7)
                            @if($pul7->core_id_product==$pL->idm_data_product AND $pul7->product_size=="Besar")
                                <span class="check-number">{{$pul7->stock}}</span>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>