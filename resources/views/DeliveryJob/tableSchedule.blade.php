<?php
    $nomor = 1;
?>
<table class="table table-sm table-valign-middle table-hover">
    <thead>
        <tr>
            <th></th>
            <th>Pelanggan</th>
            <th>Produk</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listPengiriman as $lpr)
            <tr>
                <td class="text-left">
                    <button type="button" class="btn btn-sm btn-flat btn-success"><i class="fa-solid fa-circle-check"></i></button>
                </td>
                <td>
                    <b>{{$lpr->customer_store}}</b> <br>
                    <small class="text-muted">Alamat : {{$lpr->address}}</small>
                </td>
                <td>
                    @foreach($getProductOrder as $gpo)
                        @if($gpo->customer_code == $lpr->customer_code)
                            <ul>
                                <li>{{$gpo->product_name}} : {{$gpo->qty_order}} Pcs.</li>
                            </ul>
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>