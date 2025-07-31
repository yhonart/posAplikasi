<div class="row mb-2 justify-content-center"> 
    <div class="col-md-3">
        <div class="fixed-bottom d-block d-md-none">            
            <a class="btn btn-app bg-blue BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('sales')}}/mainKurir/addNewNonSchedule">
                <i class="fas fa-barcode"></i> Non Schedule
            </a>
        </div>
    </div>   
    <div class="col-md-3">
        <label for="fromDate" class="form-label">Pilih Tanggal</label>
        <input type="text" class="form-control form-control-sm datetimepicker-input" name="fromDate" id="fromDate">
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12"> 
        <div id="contentSchedule"></div>                
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function(){
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
        let selectedDate = $("#fromDate").val();
        autoDisplay(selectedDate);
    });

    $(document).ready(function() {
        $("#fromDate").change(function(){
            let selectedDate = $('#fromDate').val();                
            autoDisplay(selectedDate);
        });
    });
    function autoDisplay(selectedDate){
        $.ajax({
            type : 'get',
            url : "{{route('sales')}}/mainKurir/funcDate/"+selectedDate,
            success : function(response){
                $("#contentSchedule").html(response);
            }
        });
    }
</script>