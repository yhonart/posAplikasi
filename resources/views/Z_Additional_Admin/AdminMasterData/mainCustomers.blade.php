<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Customers')}}/AddCustomers" ><i class="fa-solid fa-address-book"></i> New</button>
                    <a href="{{route('Customers')}}/downloadAllCustomer" class="btn btn-sm btn-success font-weight-bold" target="_blank"><i class="fa-solid fa-file-excel"></i> Download</a>
                </div>
            </div>
            <div class="col-md-4">
                
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">                
                <div class="card card-body text-xs p-0 table-responsive " style="height:700px;">
                    <input type="text" name="searchCustomer" id="searchCustomer" class="form-control mb-1 " placeholder="Cari nama pelanggan" autofocus>
                    @include('Global.global_spinner')
                    <div id="displayTableCustomers"></div>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div id="displayEditCos"></div>
            </div>
        </div>       
    </div>
</div>
<script>
    $(document).ready(function() {
        let keyWord = 0;
        searchData(keyWord);
        let timer_cari_equipment = null;
        $("#searchCustomer").keyup(function (e){
            e.preventDefault();
            clearTimeout(timer_cari_equipment);            
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#searchCustomer").val().trim();
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord)},700)
        });
        
        function searchData(keyWord){
            $("#displayDownload").fadeOut("slow");        
            $.ajax({
                type : 'get',
                url : "{{route('Customers')}}/TableDataCustomer/searchTableCus/"+keyWord,
                success : function(response){
                    $("#displayTableCustomers").html(response);
                }
            });
        }
    });
</script>