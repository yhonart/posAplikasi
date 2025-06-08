<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link TABS-NEW-VARIAN" id="btnTabsManualPrice" data-toggle="pill" href="#tabDivVarianPrice" role="tab" aria-controls="tabDivVarianPrice" aria-selected="true" data-url="modalNewVarian">Manual Varian Price</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link TABS-NEW-VARIAN" id="btnTabsManualPrice" data-toggle="pill" href="#tabDivVarianPrice" role="tab" aria-controls="tabDivVarianPrice" aria-selected="true" data-url="modalNewVarianFixed">Varian Price Fixed</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade" id="tabDivVarianPrice" role="tabpanel" aria-label="">
                        <div id="loadDisplaySpinner" style="display: none;">
                            <div class="spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span>...Please Wait !</span>
                        </div>
                        <div id="disFormVariant"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let id = "{{$id}}",
            path = "tabDivVarianPrice";
        loadDisForm(path,id);

        $('.TABS-NEW-VARIAN').on('click', function (e) {
            e.preventDefault();
            $("#loadDisplaySpinner").fadeIn();
            let path = $(this).attr('data-url');            
            loadDisForm(path,id)
        });
        
        function loadDisForm(path,id){
            $.ajax({
                type : 'get',
                url : "{{route('sales')}}/mainProduct/newProduct/"+path+"/"+id,
                success : function(response){
                    $("#loadDisplaySpinner").fadeOut();
                    $('#disFormVariant').html(response);
                }
            });
        }
    });
</script>