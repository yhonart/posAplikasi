<table class="table table-sm table-valign-middle">
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