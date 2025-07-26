<div class="row">
    <div class="col-md-12">
        <table class="table table-sm table-valign-middle table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Qty Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($produkOrder as $por)
                    <tr>
                        <td>{{$por->product_name}}</td>
                        <td>{{$por->qty_order}}</td>
                        <td>
                            <button type="button" class="btn btn-default btn-sm border-0 DELETE-ORDER" id-data="{{$por->cus_order_id}}"><i class="fa-solid fa-xmark text-danger"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('.DELETE-ORDER').on('click', function (e) {
            e.preventDefault();
            let ell = $(this);
            let dataID = ell.attr("id-data");
            $.ajax({
                type : 'get',
                url : "{{route('sales')}}/formKunjungan/tableProdukDeal/deletedOrder/"+dataID,
                success : function(response){
                    loadTableOrder ();
                }
            });
        });
        function loadTableOrder (){
            $("#displayTableProduk").load("{{route('sales')}}/formKunjungan/tableProdukDeal");
        }
    });
</script>