<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Item Return</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-sm table-hover table-valign-middle">
            <thead>
                <tr>
                    <th>No.Pembelian</th>
                    <th>Produk</th>
                    <th>Qty.Pembelian</th>
                    <th>Qty.Retur</th>
                    <th>Hrg.Satuan</th>
                    <th>Jml.Retur</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemReturn as $iR)
                    <tr>
                        <td>{{$iR->purchase_number}}</td>
                        <td>{{$iR->product_name}}</td>
                        <td><span class="font-weight-bold text-info">{{$iR->received}}</span></td>
                        <td><span class="font-weight-bold text-indigo">{{$iR->return}} {{$iR->unit}}</span></td>
                        <td class="text-right">{{number_format($iR->unit_price,'0',',','.')}}</td>
                        <td class="text-right">{{number_format($iR->total_price,'0',',','.')}}</td>
                        <td>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>