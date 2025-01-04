
<table class="table table-sm table-valign-middle table-hover " id="dokTableRetur">
    <thead class="bg-gray-dark">
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
                <td class="text-right">
                    @if($pr->payment_methode <> '1' AND $pr->payment_methode <> '2' AND $pr->tempo <> "")
                        <span class="pt-1 pb-1 pl-2 pr-2 bg-warning rounded-pill font-weight-bold">{{$pr->tempo}} Hari</span>
                    @elseif($pr->tempo == "")
                        <span class="pt-1 pb-1 pl-2 pr-2 bg-danger rounded-pill font-weight-bold">UNKNOWN</span>
                    @else
                        <span class="pt-1 pb-1 pl-2 pr-2 bg-success rounded-pill font-weight-bold">{{$pr->tempo}}</span>
                    @endif
                </td>
                <td class="text-right"> 
                    <button class="btn btn-sm btn-primary font-weight-bold float-right DIS-ITEM" title="Retur Item" data-purchase="{{$pr->purchase_number}}"><i class="fa-solid fa-rotate-right"></i> Retur</button>
                    <button class="btn btn-sm btn-info font-weight-bold float-right DETAIL-ITEM" title="Detail" data-purchase="{{$pr->purchase_number}}"><i class="fa-solid fa-magnifying-glass"></i> Detail</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(function(){        
        $("#dokTableRetur").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $(document).ready(function(){
        $(".dataTable").on('click','.DIS-ITEM', function (e) {
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
        $(".dataTable").on('click','.DETAIL-ITEM', function (e) {
            e.preventDefault();
            let el = $(this),
                purchaseNumber = el.attr('data-purchase');
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/purchasingList/detailItem/"+purchaseNumber,
                    success : function(response){
                        $("#displayInfo").html(response);
                    }
                });
        });
    }); 
</script>