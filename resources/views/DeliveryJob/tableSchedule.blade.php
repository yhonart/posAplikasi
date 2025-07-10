<?php
    $nomor = 1;
?>
<table class="table table-sm table-valign-middle table-hover">
    <thead>
        <tr>
            <th>No.</th>
            <th>Pelanggan</th>
            <th>Produk</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($listPengiriman as $lpr)
            <tr>
                <td>{{$nomor++}}</td>
                <td>
                    <b>{{$lpr->customer_store}}</b> <br>
                    <small class="text-muted">Alamat : {{$lpr->address}}</small>
                </td>
                <td>

                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-sm btn-flat btn-default"><i class="fa-solid fa-circle-check text-success"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>