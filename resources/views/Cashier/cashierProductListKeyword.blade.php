@foreach($productList as $pL)
<tr>
    <td colspan="2" class="p-0">
        <button class="btn btn-default btn-block rounded-0 border-0 onClick-produk elevation-0 btn-sm text-primary font-weight-bold" data-id="{{$pL->idm_product_satuan}}">{{$pL->product_name}}</button>
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
    <td class="p-0"></td>
</tr>
<script type="text/javascript">
    $(document).ready(function() {
        $('.onClick-produk').on('click', function (e) {
            e.preventDefault();
            let dataID = $(this).attr('data-id');
            alert (dataID);
        });
    });
</script>
@endforeach