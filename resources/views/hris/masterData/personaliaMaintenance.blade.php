<div class="row">
    <div class="col-12 col-md-3">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
            <input type="text" name="searchEmployee" id="searchEmployee" class="form-control" placeholder="Cari Nama Karyawan">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="text-center DIV-SPIN text-sm" style="display:none;">    
            <span class="spinner-grow spinner-grow-sm text-info" role="status"></span>
            <span class="spinner-grow spinner-grow-sm text-info" role="status"></span>
            <span class="spinner-grow spinner-grow-sm text-info" role="status"></span>
        </div>
        <div id="divListPersonalia"></div>
    </div>
</div>
<script>
    
    $(document).ready(function() {
        let keyWord = 0;
        searchData(keyWord);
        let timer_cari_equipment = null;
        $("#searchEmployee").keyup(function (e){
            e.preventDefault();
            $(".DIV-SPIN").fadeIn();
            clearTimeout(timer_cari_equipment);
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#searchEmployee").val().trim();
                let searchdept = "0";
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord)},700)
        });
        function searchData(keyWord){        
            $.ajax({
                type : 'get',
                url : "{{route('Personalia')}}/dataTablePersonalia/searchData/"+keyWord,
                success : function(response){
                    $(".DIV-SPIN").fadeOut();
                    $("#divListPersonalia").html(response);
                }
            });
        }
    });
</script>