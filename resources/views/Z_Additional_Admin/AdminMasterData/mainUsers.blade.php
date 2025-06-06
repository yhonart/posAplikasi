<div class="row">
    <div class="col-md-12">
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="btn-group">
                    <button class="btn btn-info font-weight-bold ITEM-DISPLAY" id="tambahPersonalia" data-open="newUsers"><i class="fa-solid fa-plus"></i> Tambah User</button>
                    <button class="btn btn-default text-info font-weight-bold ITEM-DISPLAY" id="listPersonalia" data-open="dataTablePersonalia"><i class="fa-solid fa-list"></i> List Data</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">                
                <div class="card">
                    <div class="card-body text-xs">
                        @include('Global.global_spinner')
                        <div id="displayDataPersonalia"></div>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</div>
<script>
    $(document).ready(function(){
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Personalia')}}",
            tableData = "dataTablePersonalia",
            displayData = $("#displayDataPersonalia");
        
        $('.ITEM-DISPLAY').on('click', function (e) {
            e.preventDefault();
            let tableData = $(this).attr('data-open');
            loadSpinner.fadeOut();
            displayData.load(routeIndex+"/"+tableData);
        });
        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>