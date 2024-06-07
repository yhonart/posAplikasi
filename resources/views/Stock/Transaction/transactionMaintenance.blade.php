<div class="row">    
    <div class="col-6 col-md-3">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
            <input type="text" name="SearchProduk" id="SearchProduk" class="form-control" placeholder="Cari Produk">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        @include('Global.global_spinner')
        <div id="divListProduct"></div>
    </div>
</div>
<script>
    $( function() {
        $( "#selectDateTrans" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#selectDateTrans').datepicker("setDate",new Date());
    } );
    $(document).ready(function() {
        let keyWord = 0;

        searchData(keyWord);
        let timer_cari_equipment = null;
        $("#SearchProduk").keyup(function (e){
            e.preventDefault();
            $(".LOAD-SPINNER").fadeIn();
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
                url : "{{route('TransProduct')}}/StockBarang/SearchProduct/"+keyWord,
                success : function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    $("#divListProduct").html(response);
                }
            });
        }
    });
</script>