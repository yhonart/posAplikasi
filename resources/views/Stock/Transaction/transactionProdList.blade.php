<style>
    dl dt:hover {
        background-color: rgba(0,0,0,.075);
    }
</style>
<div id="loadPaginate">
    <div class="row">
        <div class="col-12 col-md-3">
            {{$productList->links()}}
            <table class="table table-valign-middle table-bordered table-hover">
                <thead class="text-center bg-gradient-indigo">
                    <tr>
                        <th>Nama Produk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productList as $pl)
                        <tr>
                            <td class="font-weight-bold"> 
                                <a class="text-navy CLICK-PRODUCT" href="#" data-id="{{$pl->idm_data_product}}">
                                    {{$pl->product_name}}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-12 col-md-9">
            <div id="detailProduct"></div>
        </div>
    </div>
    
</div>
<script>
    function ajaxPaging() {
        $('.pagination a').on('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#loadPaginate').load(url);
        });
    }
    ajaxPaging();
    $(document).ready(function(){
        $(".CLICK-PRODUCT").on('click',function(){
            let el = $(this),
                prodID = el.attr('data-id');
                
            $.ajax({
                type:'get',
                url:"{{route('Stock')}}/ProductMaintenance/MenuPriceEdit/"+prodID, 
                success : function(response){
                    $("#detailProduct").html(response);
                }           
            });  
                
        })
    })
</script>