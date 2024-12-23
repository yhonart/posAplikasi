<div class="row">
    <div class="col-md-12">
        <p>TEST</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="tableFilter"></div>
    </div>
</div>

<script>
    $(function(){
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
        
        $('#supName').select2({
            theme: 'bootstrap4',
        });

        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/Bayar",
            success : function(response){
                $('#tableFilter').html(response);
            }
        });
    });
</script>