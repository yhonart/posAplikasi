<table border="1">
    <thead>
        <tr>
            <th>ID trx</th>
            <th>Prod ID</th>
            <th>Hharga Jual</th>
            <th>Hharga Beli</th>
        </tr>
    </thead>
    <tbody>
        @foreach($getDataTrx as $gdt)
            <tr>
                <td>{{$gdt->list_id}}</td>
                <td>{{$gdt->product_code}}</td>
                <td>{{$gdt->m_price}}</td>
                <td>
                    @foreach($getDataOrder as $gdo)
                        @if($gdo->core_id_product == $gdt->product_code AND $gdo->product_size == $gdt->satuan)
                            {{$gdo->product_price_order}}
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>