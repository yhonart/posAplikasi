<div class="row">
    <div class="col-md-8">
        <div class="card card-blue">
            <div class="card-header">
                <h3 class="card-title">Schedule</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm datetimepicker-input" name="fromDate" id="fromDate">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="contentSchedule"></div>
                    </div>
                </div>
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