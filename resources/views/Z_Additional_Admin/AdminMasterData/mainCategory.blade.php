<div class="row">
    <div class="col-md-12">
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="btn-group">
                    <button class="btn btn-info font-weight-bold ITEM-DISPLAY" id="addCategory" data-open="newCategory"><i class="fa-solid fa-plus"></i> New</button>
                    <button class="btn btn-default text-info font-weight-bold ITEM-DISPLAY" id="listCategory" data-open="dataTableCategory"><i class="fa-solid fa-list"></i> List Data</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">                
                <div class="card">
                    <div class="card-body text-xs">
                        @include('Global.global_spinner')
                        <div id="displayDataCategory"></div>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</div>
<script>
    $(document).ready(function(){
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('sales')}}/mainCategory",
            tableData = "dataTableCategory",
            displayData = $("#displayDataCategory");
        
        $('.ITEM-DISPLAY').on('click', function (e) {
            e.preventDefault();
            let tableData = $(this).attr('data-open');
            loadSpinner.fadeOut();
            displayData.load(routeIndex+"/"+tableData);
        });
        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>