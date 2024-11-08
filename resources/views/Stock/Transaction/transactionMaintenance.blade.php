<div class="row">
    <div class="col-md-3">
        <div class="sticky-top mb-3">
            <div class="card card-body  pr-1 pl-1">
                <div class="row">    
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="SearchProduk" id="SearchProduk" class="form-control" placeholder="Cari Produk" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-info BTN-ADD-NEW btn-block btn-sm mb-1" href="{{route('Stock')}}/AddProduct">Tambah Produk</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="divListProduct"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-9">
        <div class="card card-body">
            <div id="detailProduct"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let keyWord = 0;
        searchData(keyWord);
        let timer_cari_equipment = null;
        $("#SearchProduk").keyup(function (e){
            e.preventDefault();
            clearTimeout(timer_cari_equipment);
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#SearchProduk").val().trim();
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord)},700)
        });
        
        function searchData(keyWord){        
            $.ajax({
                type : 'get',
                url : "{{route('TransProduct')}}/StockBarang/cariTransaksiProduk/"+keyWord,
                success : function(response){
                    $("#divListProduct").html(response);
                }
            });
        }
        
        
        $(".BTN-ADD-NEW").on('click',function(){
            let el = $(this),
                prodID = el.attr('data-id');
                
            $.ajax({
                type:'get',
                url:"{{route('Stock')}}/AddProduct", 
                success : function(response){
                    $("#detailProduct").html(response);
                }           
            });  
                
        })
    
    });
</script>