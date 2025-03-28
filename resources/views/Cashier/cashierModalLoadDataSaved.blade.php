<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Load Data Yang Tersimpan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body text-xs">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fromDate">Dari Tanggal</label>
                            <input type="text" class="form-control form-control-sm datetimepicker-input " id="fromDate" name="fromDate"/>
                        </div>
                    </div>                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="endDate">S.d Tanggal</label>
                            <input type="text" class="form-control form-control-sm datetimepicker-input " id="endDate" name="endDate"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tampilDataSimpan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $( function() {
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
    } );
    
    $(document).ready(function(){
        let fromDate = $('#fromDate').val(),
            endDate = $('#endDate').val();

        functLoadData(fromDate,endDate );
        
        $("#fromDate").change(function(){
            let fromDate = $('#fromDate').val(),
                endDate = $('#endDate').val();

            functLoadData(fromDate,endDate );
        });

        $("#endDate").change(function(){
            let fromDate = $('#fromDate').val(),
                endDate = $('#endDate').val();

            functLoadData(fromDate,endDate);
        });

        function functLoadData(fromDate,endDate){        
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPenjualan/tampilData/"+fromDate+"/"+endDate,
                success : function(response){
                    $(".tampilDataSimpan").html(response);
                }
            });
        }
    });
</script>