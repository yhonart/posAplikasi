@foreach($productList as $pL)
<tr data-id="{{$pL->idinv_stock}}">
    <td colspan="2" class="p-0">
        <button class="btn btn-default btn-block rounded-0 border-0 onClick-produk elevation-0 btn-sm text-primary font-weight-bold text-left" data-id="{{$pL->idinv_stock}}">{{$pL->product_name}}</button>
    </td>
    <td class="p-0"></td class="p-0">
    <td class="p-0">
        {{$pL->product_satuan}}
    </td class="p-0">
    <td class="text-right p-0">
        @foreach($getPrice as $gp)
            @if($gp->core_product_price == $pL->idm_data_product AND $gp->size_product == $pL->product_size)
                {{number_format($gp->price_sell,'0',',','.')}}
            @endif
        @endforeach
    </td>
    <td class="p-0"></td>
    <td class="p-0"></td>
    <td class="p-0 text-right">{{$pL->stock}}</td>
    <td class="p-0"></td>
</tr>
<script type="text/javascript">
    $(document).ready(function() {
        $('.onClick-produk').on('click', function (e) {
            e.preventDefault();
            let dataID = $(this).attr('data-id'),
                billNumber = "{{$billNumber}}",
                cusGroup = "{{$cosGroup}}";
            let routeIndex = "{{route('Cashier')}}",
                urlProductList = "productList",
                panelProductList = $("#mainListProduct");
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/inputItem/"+dataID+"/"+billNumber+"/"+cusGroup,
                success : function(response){                
                    reloadTableItem(billNumber);
                    sumTotalBelanja(billNumber)
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                }
            });
        });

        function reloadTableItem(billNumber){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/listTableTransaksi/"+billNumber,
                success : function(response){                
                    $("#trLoadProduct").html(response);
                }
            });
        }
            
        function sumTotalBelanja(billNumber){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/updateTotalBeanja/"+billNumber,
                success : function(response){
                    $('#totalBelanja').html(response);
                }
            });
        }
    });
</script>
@endforeach