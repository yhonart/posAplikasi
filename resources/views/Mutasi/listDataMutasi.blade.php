
<div class="row">
    <div class="col-12">
        <div id="displayDetail"></div>
    </div>
</div>
<div id="tableDocMutasi">
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
                                <option value="4">Barang Diterima</option>
                                <option value="0">Delete</option>
                            </select>                        
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="displayTableMutasiBarang"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12 d-flex float-right">
            <a class="text-muted BTN-OPEN-MODAL-GLOBAL-LG font-weight-bold" href="{{route('mutasi')}}/manualBook"><i class="fa-solid fa-book"></i> Flow Proses Mutasi</a>            
        </div>
    </div>
</div>
<script>
    $(function(){
        var date = new Date();
        var minDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 2);
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            maxDate: date,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
    });

    $(document).ready(function(){
        let fromDate = '0',
            endDate = '0',
            status = '2';
        
        searchData(fromDate, endDate, status);

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
                url : "{{route('mutasi')}}/tableDokMutasi/"+fromDate+"/"+endDate+"/"+status,
                success : function(response){
                    $("#displayTableMutasiBarang").html(response);
                }
            });
        }
    });
</script>