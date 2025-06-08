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
                    <div class="tab-pane fade show active" id="tabDivVarianPrice" role="tabpanel" aria-label="">
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
    $(function(){
        let id = "{{$id}}",
            path = "modalNewVarian";
            
        $("#loadDisplaySpinner").fadeIn();
        $.ajax({
            type : 'get',
            url : "{{route('sales')}}/mainProduct/newProduct/"+path+"/"+id,
            success : function(response){
                $('#disFormVariant').html(response);
                $("#loadDisplaySpinner").fadeOut();
            }
        });
    })
    $(document).ready(function(){
        $('.TABS-NEW-VARIAN').on('click', function (e) {
            e.preventDefault();
            let path = $(this).attr('data-url'),
                id = "{{$id}}";
            $("#loadDisplaySpinner").fadeIn();
            $.ajax({
                type : 'get',
                url : "{{route('sales')}}/mainProduct/newProduct/"+path+"/"+id,
                success : function(response){
                    $('#disFormVariant').html(response);
                    $("#loadDisplaySpinner").fadeOut();
                }
            });
        });
    });
</script>