<div class="row mb-2">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Filter</label>
            <input type="text" class="form-control form-control-sm" name="dateSearch" id="dateSearch">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-info text-xs">
            <div class="card-header">
                <h3 class="card-title">List Pengiriman</h3>
            </div>
            <div class="card-body">
                <div id="displayTablePengiriman"></div>                
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
        $( "#dateSearch" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#dateSearch').datepicker("setDate",new Date());
        let selectedDate = $("#dateSearch").val();
        autoDisplay(selectedDate);
    });
    $(document).ready(function() {
        $("#dateSearch").change(function(){
            let selectedDate = $('#dateSearch').val();                
            autoDisplay(selectedDate);
        });
    });
    function autoDisplay(selectedDate){
        $.ajax({
            type : 'get',
            url : "{{route('sales')}}/mainPengiriman/selectDatePengiriman/"+selectedDate,
            success : function(response){
                $("#displayTablePengiriman").html(response);
            }
        });
    }
</script>