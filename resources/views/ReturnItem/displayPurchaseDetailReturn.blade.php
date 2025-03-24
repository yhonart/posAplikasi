@if($purchNumber != '0')
<div class="card card-fuchsia">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">Rincian Pembelian</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-valign-middle table-hover">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th class="text-right">Hrg.Satuan</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseListOrder as $plo)
                    <tr>
                        <td>{{$plo->product_name}}</td>
                        <td>{{$plo->qty}}</td>
                        <td>{{$plo->satuan}}</td>
                        <td class="text-right">{{number_format($plo->unit_price,'0',',','.')}}</td>
                        <td class="text-right">{{number_format($plo->total_price,'0',',','.')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold text-info">Rincian Pengembalian/Retur</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-valign-middle table-hover">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Warehouse</th>
                    <th class="text-right">Hrg.Satuan</th>
                    <th class="text-right">Total</th>
                    <th>keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseReturn as $pr)
                    <tr>
                        <td>{{$pr->product_name}}</td>
                        <td>{{$pr->return}}</td>
                        <td>{{$pr->unit}}</td>
                        <td>{{$pr->site_name}}</td>
                        <td class="text-right">{{number_format($pr->unit_price,'0',',','.')}}</td>
                        <td class="text-right">{{number_format($pr->total_price,'0',',','.')}}</td>
                        <td>{{$pr->item_text}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>