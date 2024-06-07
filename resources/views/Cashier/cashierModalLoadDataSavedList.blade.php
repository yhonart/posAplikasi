<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th>No. Trx</th>
            <th>Pelanggan</th>
            <th>Last T.Barang</th>
            <th>Last T.Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataSaved as $dS2)
            <tr>
                <td class="font-weight-bold">
                    <a class="text-info load-transaksi" href="#" data-id="{{$dS2->billing_number}}">
                        {{$dS2->billing_number}}
                    </a>
                </td>
                <td class="font-weight-bold">
                    {{$dS2->customer_name}}
                </td>
                <td>{{$dS2->t_item}}</td>
                <td>{{number_format($dS2->t_bill,'0',',','.')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    
    $(document).ready(function(){
        $(".load-transaksi").click(function(){
            var element = $(this) ;
            var data = element.attr("data-id");
            let routeIndex = "{{route('Cashier')}}",
                urlProductList = "productList",
                panelProductList = $("#mainListProduct"),
                urlButtonForm = "buttonAction",
                panelButtonForm = $("#mainButton");
            $.ajax({
                type : "get",
                url: "{{route('Cashier')}}/buttonAction/dataPenjualan/selectData/" + data,
                success: function(response) {                    
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                    $('#prodNameHidden').val("").focus();
                    $('body').removeClass('modal-open');
                    $(".MODAL-CASHIER").modal('hide'); 
                    $('.modal-backdrop').remove(); 
                }
            })
        }); 
    });
</script>