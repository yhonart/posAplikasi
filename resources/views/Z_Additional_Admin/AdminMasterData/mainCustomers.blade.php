<div class="row">
    <div class="col-md-12">
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Customers')}}/AddCustomers" ><i class="fa-solid fa-address-book"></i> New</button>
                    <a href="{{route('Customers')}}/downloadAllCustomer" class="btn btn-sm btn-success font-weight-bold" target="_blank"><i class="fa-solid fa-file-excel"></i> Download</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">                
                <div class="card text-xs p-0 table-responsive border border-2 border-info shadow" style="height:700px;">
                    <div class="card-header">
                        <h3 class="card-title">Nama Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <input type="text" name="searchCustomer" id="searchCustomer" class="form-control mb-1 " placeholder="Cari nama pelanggan" autofocus>
                        @include('Global.global_spinner')
                        <div id="displayTableCustomers"></div>
                    </div>
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