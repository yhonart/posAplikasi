<div class="card card-body">
    <table class="table table-sm table-valign-middle table-hover">
        <thead class="bg-gray-dark">
            <tr>
                <th>Supplier</th>
                <th>Purchase Number</th>
                <th class="text-right">Point Belanja</th>
                <th class="text-right">#</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historyReturn as $hisReturn)
                <tr>
                    <td>{{$hisReturn->store_name}}</td>
                    <td>{{$hisReturn->purchase_number}}</td>
                    <td class="text-right">{{number_format($hisReturn->price,'0',',','.')}}</td>
                    <td class="text-right">
                        @if($hisReturn->status == '2')
                            <button type="button" class="btn btn-sm btn-outline-success BTN-APPROVE font-weight-bold" data-purchase="{{$hisReturn->purchase_number}}">Approve</button>
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-info BTN-DETAIL font-weight-bold" data-purchase="{{$hisReturn->purchase_number}}">Detail</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        $(".BTN-DETAIL").on('click', function (e) {
            e.preventDefault();
            let el = $(this),
                purchaseReturn = el.attr('data-purchase');                
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/returnHistory/detailHistory/"+purchaseReturn,
                    success : function(response){
                        $("#displayInfo").html(response);
                    }
                });
        });
        $(".BTN-APPROVE").on('click', function (e) {
            e.preventDefault();
            let el = $(this),
                purchaseReturn = el.attr('data-purchase');                
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/returnHistory/approveTransaksi/"+purchaseReturn,
                    success : function(response){
                        $("#displayInfo").html(response);
                    }
                });
        });
    });
</script>