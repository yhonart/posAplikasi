@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Stock Opname Date</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid"> 
        <div class="row mb-2">
            <div class="col-12">
                <button type="button" class="btn bg-olive font-weight-bold btn-flat DIS-ONCLICK" data-display="listDataOpname"><i class="fa-solid fa-table-list"></i> List Data Opname</button>
                <button type="button" class="btn bg-lightblue font-weight-bold btn-flat DIS-ONCLICK" data-display="listInputBarang"><i class="fa-solid fa-plus"></i> Entry Data</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="displayOpname"></div>
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
        let display = "listDataOpname";
        displayOnClick(display);
    });
    
    $('.DIS-ONCLICK').on('click', function (e) {
        e.preventDefault();
        let el = $(this);
        let display = el.attr("data-display");
        displayOnClick(display);
    });
    
    function displayOnClick(display){
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/"+display,
            success : function(response){
                $('#displayOpname').html(response);
            }
        });
    }
</script>
@endsection