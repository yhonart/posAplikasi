<style>
    dl dt:hover {
        background-color: rgba(0,0,0,.075);
    }
</style>
<div id="loadPaginate">
    <div class="row">
        <div class="col-md-12">
            <div class="sticky-top mb-3">
                <div class="card card-body table-responsive p-0" style="height:500px;">
                    <table class="table table-valign-middle table-hover text-sm table-sm">
                        <tbody>
                            @foreach($productList as $pl)
                                <tr>
                                    <td class="p-1"> 
                                        <a class="text-navy CLICK-PRODUCT" href="#" data-id="{{$pl->idm_data_product}}">
                                            {{$pl->product_name}}
                                        </a>
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