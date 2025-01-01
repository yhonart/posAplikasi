<table class="table table-sm table-valign-middle">
    <thead>
        <tr>
            <th>Kasir</th>
            <th>Dana Tertarik</th>
            <th>Saldo Dana</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tableDana as $td)
            <tr>
                <td>{{$td->kasir}}</td>
                <td>Rp. {{number_format($td->nominal,'0',',','.')}}</td>                
                <td>Rp. {{number_format($td->saldo_kas,'0',',','.')}}</td>                
            </tr>
        @endforeach
    </tbody>
</table>