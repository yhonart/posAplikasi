@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Master Data Supplier</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">            
        <div class="row">
            <div class="col-12">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG mb-2 btn-flat btn-block" href="{{route('Supplier')}}/AddSupliyer">Tambah Supplier</button>
                <input type="text" name="searchSupplier" id="searchSupplier" class="form-control mb-1 rounded-0" placeholder="Cari nama supplier" autofocus>
                <div class="card card-body rounded-0 table-responsive p-0" style="height:700px;">
                    @include('Global.global_spinner')
                    <div id="displayTableSupplier"></div>
                </div>
            </div>
            <div class="col-md-9">
                <div id="displaySupplier"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let keyWord = 0;
        searchData(keyWord);
        let timer_cari_equipment = null;
        $("#searchSupplier").keyup(function (e){
            e.preventDefault();
            clearTimeout(timer_cari_equipment);
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#searchSupplier").val().trim();
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord)},700)
        });
        
        function searchData(keyWord){        
            $.ajax({
                type : 'get',
                url : "{{route('Supplier')}}/tableSupplier/searchTableSup/"+keyWord,
                success : function(response){
                    $("#displayTableSupplier").html(response);
                }
            });
        }
    });
</script>
@endsection