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
                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>