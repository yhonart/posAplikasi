@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Setup Metode Pembayaran</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">
        @include('Global.global_spinner')
        <div id="displayTablePembayaran"></div>
    </div>
</div>
<script>
    $(function(){
        $.ajax({
            type : 'get',
            url : "{{route('setPembayaran')}}/tableSetPembayaran",
            success : function(response){
                $("#displayTablePembayaran").html(response);
            }
        });
    });
</script>
@endsection