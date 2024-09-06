
<table class="table table-sm table-valign-middle animate__animated animate__fadeIn table-hover">
    <thead class="bg-gradient-purple">
        <tr>
            <th>No. Pembelian</th>
            <th>Tgl. Pengiriman</th>
            <th>Supplier</th>
            <th>Pembayaran</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tbPurchase as $pr)
            <tr>
                <td><span class="font-weight-bold">{{$pr->purchase_number}}</span></td>
                <td>{{$pr->delivery_date}}</td>
                <td>{{$pr->store_name}}</td>
                <td>
                    @if($pr->payment_methode <> '1' AND $pr->payment_methode <> '2' AND $pr->tempo <> "")
                        <span class="pt-1 pb-1 pl-2 pr-2 bg-warning rounded-pill font-weight-bold">{{$pr->tempo}} Hari</span>
                    @elseif($pr->tempo == "")
                        <span class="pt-1 pb-1 pl-2 pr-2 bg-danger rounded-pill font-weight-bold">UNKNOWN</span>
                    @else
                        <span class="pt-1 pb-1 pl-2 pr-2 bg-success rounded-pill font-weight-bold">{{$pr->tempo}}</span>
                    @endif
                </td>
                <td> 
                    <button type="button" class="btn btn-sm bg-olive btn-flat font-weight-bold float-right DIS-ITEM" title="Tampilkan item" data-purchase="{{$pr->purchase_number}}"><i class="fa-solid fa-rotate-right"></i> Retur Barang</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('.DIS-ITEM').on('click', function(e){
            e.preventDefault();
            let el = $(this),
                purchaseNumber = el.attr('data-purchase');
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/purchasingList/displayItemList/"+purchaseNumber,
                    success : function(response){
                        $("#displayInfo").html(response);
                    }
                });
        });
    }); 
</script>