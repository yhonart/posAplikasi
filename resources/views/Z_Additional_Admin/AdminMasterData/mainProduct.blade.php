<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow" style="height: 700px;">
            <div class="card-header">
                <h3 class="card-title">Daftar Produk</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-info btn-flat btn-sm btn-block" id="btnNewProduct">New Product</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table>
                            <tbody>
                                @foreach($productCode as $pc)
                                    <tr>
                                        <td>
                                            <a href="#" class="font-weight-bold text-black" data-id="{{$pc->idm_data_product}}">{{$pc->product_name}}</a>
                                        </td>
                                    </tr>
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="divContentProduct"></div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#btnNewProduct').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type : 'get',
                url : "{{route('sales')}}/mainProduct/newProduct",
                success : function(response){
                    $('#divContentProduct').html(response);
                }
            });
        });
    });
</script>