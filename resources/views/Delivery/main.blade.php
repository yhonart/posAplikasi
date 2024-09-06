@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
        <h1 class="m-0">Master Data Tipe Pengiriman<small>-Input & Edit data metode pengiriman</small></h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid"> 
        <div class="row mt-2">
            <div class="col-12">
                <button class="btn btn-md bg-purple elevation-1 rounded-lg" type="button" id="btnNewDelivery"><i class="fa-solid fa-plus"></i> New Type Delivery</button>
                <button class="btn btn-md bg-purple elevation-1 rounded-lg" type="button" id="btnListDelivery"><i class="fa-solid fa-list"></i> List Type Delivery</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div id="displayDelivery"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(function(){
        displayList();
    })
    
    $('#btnNewDelivery').on('click', function (e) {
        e.preventDefault();
        displayForm();
    });
    
    $('#btnListDelivery').on('click', function (e) {
        e.preventDefault();
        displayList();
    });
    
    function displayList(){
        $.ajax({
            type : 'get',
            url : "{{route('Delivery')}}/tableDataDelivery",
            success : function(response){
                $('#displayDelivery').html(response);
            }
        });
    }
    function displayForm() {
        $.ajax({
            type : 'get',
            url : "{{route('Delivery')}}/formEntryDelivery",
            success : function(response){
                $('#displayDelivery').html(response);
            }
        });
    } 
    
    
</script>
@endsection