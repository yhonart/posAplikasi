<div class="row">
    <div class="col-12">
        <div id="detailOpname"></div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">            
            <div class="card-body table-responsive">
                <div class="row mt-1 mb-2">
                    <div class="col-md-3">
                        <label for="" class="label">Dari Tgl.</label>
                        <input type="text" class="form-control form-control-sm datetimepicker-input " name="fromDate" id="fromDate" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for="" class="label">Sd. Tgl.</label>
                        <input type="text" class="form-control form-control-sm datetimepicker-input " name="endDate" id="endDate" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for="" class="label">Select Status</label>
                        <select name="status" id="status" class="form-control form-control-sm">
                            <option value="2">Submited</option>
                            <option value="1">Proses</option>
                            <option value="3">Disetujui</option>
                            <option value="0">Delete</option>
                        </select>                        
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div id="displayTableOpname"></div>
                    </div>
                </div>
            </div>
        </div>
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
    });

    $(document).ready(function(){
        let fromDate = '0',
            endDate = '0',
            status = $('#status').val();
        
        searchData(fromDate, endDate);
        $("#fromDate").change(function(){
                fromDate = $('#fromDate').val();
                endDate = $('#endDate').val();               
                status = $('#status').val();
                if(fromDate === '' || endDate === ''){
                    fromDate = '0';
                    endDate = '0';
                }    
                searchData(fromDate, endDate, status);
        });

        $("#endDate").change(function(){
                fromDate = $('#fromDate').val();
                endDate = $('#endDate').val();
                status = $('#status').val();
                if(fromDate === '' || endDate === ''){
                    fromDate = '0';
                    endDate = '0';
                }  
                searchData(fromDate, endDate, status);
        });

        $("#status").change(function(){
                fromDate = $('#fromDate').val();
                endDate = $('#endDate').val();
                status = $(this).find(":selected").val();
                if(fromDate === '' || endDate === ''){
                    fromDate = '0';
                    endDate = '0';
                }  
                searchData(fromDate, endDate, status);
        });

        function searchData(fromDate, endDate, status){ 
            $.ajax({
                type : 'get',
                url : "{{route('stockOpname')}}/listTableOpname/"+fromDate+"/"+endDate+"/"+status,
                success : function(response){
                    $("#displayTableOpname").html(response);
                }
            });
        }
    });
</script>