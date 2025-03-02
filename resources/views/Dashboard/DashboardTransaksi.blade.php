<div class="row">
    <div class="col-6 col-md-3">
        <div class="form-group">
            <label class="form-label">Cari Dari Tanggal</label>
            <input type="text" class="form-control form-control-sm form-control-border border-width-2 border-info datetimepicker-input" name="dariTanggal" id="dariTanggal">
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="form-group">
            <label class="form-label">s.d Tanggal</label>
            <input type="text" class="form-control form-control-sm form-control-border border-width-2 border-info datetimepicker-input" name="sampaiTanggal" id="sampaiTanggal">
        </div>
    </div>       
</div>
<div class="row">
    <div class="col-12">
        <div id="loadDataDashboard"></div>
    </div>
</div>
<script>
    $(function() {
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
        $('#searchDataReturn').val('').focus();        
    });
    
    $(document).ready(function(){
        let fromDate = $('#dariTanggal').val(),
            endDate = $('#sampaiTanggal').val();
        funcLoadDataTrx(fromDate, endDate);
            
        $("#dariTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val();
            
            funcLoadDataTrx(fromDate, endDate);
        });

        $("#sampaiTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val();
                
            funcLoadDataTrx(fromDate, endDate);
        });
        
        function funcLoadDataTrx(fromDate, endDate){
            $(".LOAD-SPINNER").fadeIn();
            $.ajax({
                type : 'get',
                url : "{{route('Dashboard')}}/loadDataTransaksi/"+fromDate+"/"+endDate,
                success : function(response){
                    $("#loadDataDashboard").html(response);
                    $(".LOAD-SPINNER").fadeOut();
                }
            });
        };
        
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('TransProduct')}}",
            tableData = "StockBarang",
            displayData = $("#diplayTransaction");
        
        $('.ITEM-DISPLAY').on('click', function (e) {
            e.preventDefault();
            let tableData = $(this).attr('data-open');
            loadSpinner.fadeOut();
            displayData.load(routeIndex+"/"+tableData);
        });
        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
    });
</script>