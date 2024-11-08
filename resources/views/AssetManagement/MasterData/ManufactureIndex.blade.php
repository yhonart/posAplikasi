@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Master Data Brand</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">            
        <div class="row">
            <div class="col-12">
                <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG  font-weight-bold" href="{{route('M_Manufacture')}}/AddManufacture">Tambah Brand</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('Global.global_spinner')
                        <div id="displayTableManufacture"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('M_Manufacture')}}",
            tableData = "arrayManufacture",
            displayData = $("#displayTableManufacture");

        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>
@endsection