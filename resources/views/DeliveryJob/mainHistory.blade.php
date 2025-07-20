<div class="row mb-2 justify-content-center">    
    <div class="col-md-3">
        <label for="historyDate" class="form-label">Pilih Tanggal</label>
        <input type="text" class="form-control form-control-sm datetimepicker-input" name="historyDate" id="historyDate">
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12"> 
        <div id="contentHistoryDelivery"></div>                
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p class="muted font-weight-bold">* Secara Default Data Yang Ditampilkan Adalah Data Pada Hari Ini.</p>
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
        let selectedDate = $("#historyDate").val();
        autoDisplay(selectedDate);
    });

    $(document).ready(function() {
        $("#historyDate").change(function(){
            let selectedDate = $('#historyDate').val();                
            autoDisplay(selectedDate);
        });
    });
    function autoDisplay(selectedDate){
        $.ajax({
            type : 'get',
            url : "{{route('sales')}}/mainKurir/historyDate/"+selectedDate,
            success : function(response){
                $("#contentHistoryDelivery").html(response);
            }
        });
    }
</script>