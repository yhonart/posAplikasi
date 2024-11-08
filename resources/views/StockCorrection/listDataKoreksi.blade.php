<?php
    $nosum = '1';
    $araystatus = array(
        1=>"On Process",
        2=>"Submited",
        3=>"Approved",
        0=>"Deleted",
    );
    $textColor = array(
        1=>"text-info",
        2=>"text-warning",
        3=>"text-success",
        0=>"text-danger",
    );
?>
<div id="table_my_events">
    <div class="text-center LOAD-SPINNER text-sm" style="display:none;">    
        <span class="spinner-grow spinner-grow-sm" role="status"></span> Please Wait !
    </div>
    
    <div class="row mb-2">
        <div class="col-12">
            <div id="detailKoreksi"></div>
        </div>
    </div>

    <div class="card table-responsive p-1">        
        <div class="card-body">  
            <div class="row mt-1 mb-2">
                <div class="col-md-3">
                    <label for="" class="label">Dari Tgl.</label>
                    <input type="text" class="form-control form-control-sm datetimepicker-input " name="fromDate" id="fromDate" autocomplete="off">
                </div>
                <div class="col-md-3">
                    <label for="" class="label">Sd. Tgl.</label>
                    <input type="text" class="form-control form-control-sm datetimepicker-input " name="endDate" id="endDate" autocomplete="off">
                </div>
            </div>
            <hr>             
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <div id="divTableKoreksi"></div>
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
        let fromDate = $('#fromDate').val(),
            endDate = $('#endDate').val();
        
        searchData(fromDate, endDate);
        $("#fromDate").change(function(){
                fromDate = $('#fromDate').val(),
                endDate = $('#endDate').val();

                if(fromDate === '' || endDate === ''){
                    fromDate = '0';
                    endDate = '0';
                }    
                searchData(fromDate, endDate);
        });

        $("#endDate").change(function(){
                fromDate = $('#fromDate').val(),
                endDate = $('#endDate').val();
                if(fromDate === '' || endDate === ''){
                    fromDate = '0';
                    endDate = '0';
                }  
                searchData(fromDate, endDate);
        });

        function searchData(fromDate, endDate){ 
            $.ajax({
                type : 'get',
                url : "{{route('koreksiBarang')}}/filterByDate/"+fromDate+"/"+endDate,
                success : function(response){
                    $("#actionDisplay").html(response);
                }
            });
        }
    });

    
</script>