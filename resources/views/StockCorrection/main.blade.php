@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Koreksi Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item text-muted">Home</li>
                <li class="breadcrumb-item text-muted">Inventory</li>
                <li class="breadcrumb-item text-info active">Koreksi</li>
            </ol>
        </div>
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid"> 
        <div class="row mb-2">
            <div class="col-12">
                <button class="btn btn-outline-primary font-weight-bold  DIS-ONCLICK" data-display="listDataKoreksi"><i class="fa-solid fa-table-list"></i> List Dok. Koreksi</button>
                <button class="btn btn-primary font-weight-bold  DIS-ONCLICK" data-display="listInputBarang"><i class="fa-solid fa-plus"></i> Entry Data</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="displayOnDiv"></div>
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
        let display = "listDataKoreksi";
        displayOnClick(display);
    });
    
    $('.DIS-ONCLICK').on('click', function (e) {
        e.preventDefault();
        let el = $(this);
        let display = el.attr("data-display");
        $("#displayNotif").fadeIn("slow");
        displayOnClick(display);
        $("#displayNotif").fadeOut("slow");
    });
    
    function displayOnClick(display){
        $.ajax({
            type : 'get',
            url : "{{route('koreksiBarang')}}/"+display,
            success : function(response){
                $('#displayOnDiv').html(response);
            }
        });
    }
     
</script>
@endsection