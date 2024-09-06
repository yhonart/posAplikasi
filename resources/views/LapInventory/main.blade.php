@extends('layouts.sidebarpage')
@section('content')

    <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-8 col-12">          
                        <h1 class="m-0">Laporan Inventory</h1>
                    </div>          
                </div>
            </div>
        </div>
    <!-- content -->
    <div class="content mt-0">
        <div class="container-fluid">
            @if($checkArea <> 0).
            <div class="row">
                <div class="col-12">
                   <div id="displayInfo"></div>
                </div>
            </div>
            @else
                <div class="row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="alert alert-warning alert-dismissible text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            <span class="font-weight-bold">
                                User anda belum memiliki hak akses dikarenakan belum di setup area kerjanya, silahkan hubungi administrator untuk lebih lanjutnya!
                            </span>
                        </div>                        
                    </div>
                </div>
            @endif
        </div>
    </div>
<script>
    $(function () {
        let display = "formFiltering";
        $.ajax({
            type : 'get',
            url : "{{route('lapInv')}}/"+display,
            success : function(response){
                $("#displayInfo").html(response);
            }
        });
    }); 
</script>
@endsection