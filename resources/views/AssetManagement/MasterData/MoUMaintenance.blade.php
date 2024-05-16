<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Master Data Satuan</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
            <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('MoU')}}/AddMoU">Tambah Satuan</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('Global.global_spinner')
                        <div id="displayTableMoU"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('MoU')}}",
            tableData = "tableMoU",
            displayData = $("#displayTableMoU");
        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>