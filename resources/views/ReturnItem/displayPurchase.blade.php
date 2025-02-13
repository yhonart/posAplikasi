<div class="card card-purple">
    <div class="card-header">
        <h3 class="card-title">List Dokumen Transaksi Pembelian</h3>
    </div>
    <div class="card-body table-responsive">
        <div class="row mb-2">
            <div class="col-md-4">
                <input type="text" class="form-control " name="keyword" id="keyword" placeholder="Cari Nomor Transaksi / Supplier" autocomplate="off">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="displaySearchData"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let keywords = '0',
            timer_search_data = null;
        displaySearch(keywords);
        
        $("#keyword").keyup(function (e){
            e.preventDefault();
            clearTimeout(timer_search_data);
            timer_search_data = setTimeout(function(){
                let keywords = $("#keyword").val().trim();
                if(keywords == ''){
                    keywords = '0';
                }
                displaySearch(keywords);
            },700)
        });
        
        function displaySearch(keywords) {
            $.ajax({
                type : 'get', 
                url : "{{route('returnItem')}}/purchasingList/searchData/"+keywords,
                success : function(response){ 
                    $('#displaySearchData').html(response); 
                } 
            });
        }
    })
</script>