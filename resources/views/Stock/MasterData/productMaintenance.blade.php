<div class="row">
    <div class="col-12 col-md-4">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
            <input type="text" name="SearchProduk" id="SearchProduk" class="form-control" placeholder="Cari Produk">
        </div>
        <div id="divListProduct"></div>
    </div>
</div>
<script>    
    $(document).ready(function() {
        let keyWord = 0;
        searchData(keyWord);
        let timer_cari_equipment = null;
        $("#SearchProduk").keyup(function (e){
            e.preventDefault();
            $(".DIV-SPIN").fadeIn();
            clearTimeout(timer_cari_equipment);
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#SearchProduk").val().trim();
                let searchdept = "0";
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord)},700)
        });
        function searchData(keyWord){        
            $.ajax({
                type : 'get',
                url : "{{route('Stock')}}/ProductMaintenance/SearchProduct/"+keyWord,
                success : function(response){
                    $(".DIV-SPIN").fadeOut();
                    $("#divListProduct").html(response);
                }
            });
        }
    });
</script>