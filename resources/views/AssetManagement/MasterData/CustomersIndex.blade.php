@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Master Data Pelanggan</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12 col-md-3">
                <button type="button" class="btn btn-primary btn-flat font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG btn-block mb-2" href="{{route('Customers')}}/AddCustomers" ><i class="fa-solid fa-address-book"></i> Tambah Pelanggan</button>
                <input type="text" name="searchCustomer" id="searchCustomer" class="form-control mb-1 rounded-0" placeholder="Cari nama pelanggan" autofocus>
                <div class="card card-body p-0 table-responsive rounded-0" style="height:700px;">
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
@endsection