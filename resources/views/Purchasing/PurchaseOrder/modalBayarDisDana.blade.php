<table class="table table-sm table-valign-middle">
    <thead class="bg-info">
        <tr>
            <th>Kasir</th>
            <th>Dana Tertarik</th>
            <th>Saldo Dana</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($tableDana as $td)
            <tr>
                <td>{{$td->kasir}}</td>
                <td>Rp. {{number_format($td->nominal,'0',',','.')}}</td>                
                <td>Rp. {{number_format($td->saldo_kas,'0',',','.')}}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-default BTN-DELETE" data-id="{{$td->id_dana}}"><i class="fa-solid fa-xmark"></i></button>
                </td>               
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $('.BTN-DELETE').on('click', function (e) {
            e.preventDefault();
            let display = $(this).attr('data-id'),
                kasir = "{{$kasir}}",
                apNumber = "{{$apNumber}}",
                purchaseNumber = "{{$purchaseNumber}}";                
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/deleteDana/"+display,
                success : function(response){
                    reloadUpdateTableDana (kasir,apNumber,purchaseNumber);
                }
            });
        });

        function reloadUpdateTableDana (kasir,apNumber,purchaseNumber){            
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/Bayar/getDisplaySumberDana/"+kasir+"/"+apNumber+"/"+purchaseNumber,
                success : function(response){
                    $("#displaySumberDana").html(response);
                }
            });
        }
    });
</script>