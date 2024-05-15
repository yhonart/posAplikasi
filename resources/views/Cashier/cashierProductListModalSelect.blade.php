<table class="table table-sm">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga Jual [B]</th>
            <th>Harga Jual [S]</th>
            <th>Harga Jual [K]</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($productList as $pl)
            <tr>
                <td>{{$pl->product_name}}</td>
                <td>{{number_format($pl->sellLG)}}</td>
                <td>{{number_format($pl->sellMD)}}</td>
                <td>{{number_format($pl->sellSM)}}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" id="pilihProduk" data-barang="{{$pl->product_name}}">Pilih</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function(){
        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");

        $('#pilihProduk').on('click',function (){
            let el = $(this);
            let nmProduct = el.attr("data-barang");            

            $.ajax({
                type:'get',
                url:routeIndex + "/buttonAction/manualSelectProduct/select/" + nmProduk, 
                success : function(response){
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                }           
            });            
        })
    })
</script>