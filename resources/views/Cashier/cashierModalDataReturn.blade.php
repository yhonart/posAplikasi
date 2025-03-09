<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Data Return</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Dari Tanggal</label>
                            <input type="text" class="form-control form-control-sm form-control-border border-width-2 border-info datetimepicker-input" name="fromDateReturn" id="fromDateReturn"/>                            
                        </div>
                    </div>                    
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>s.d Tanggal</label>
                            <input type="text" class="form-control form-control-sm form-control-border border-width-2 border-info datetimepicker-input" name="endDateReturn" id="endDateReturn"/>                            
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Cari</label>
                            <input type="text" class="form-control form-control-sm form-control-border border-width-2 border-info" name="searchDataReturn" id="searchDataReturn" placeholder="Nomor transaksi atau nama pelanggan" autocomplete="off"/>                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p id="adminWarning"></p>
                        <div id="divDataReturn"></div>                        
                    </div>
                </div>
            </div>
        </div>
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
        let keyword = '0',
            fromDate = $('#fromDateReturn').val(),
            endDate = $('#endDateReturn').val(),
            timer_cari_return = null;
            
        funcDataReturn(keyword, fromDate, endDate);

        $("#fromDateReturn").change(function(){
            let fromDate = $('#fromDateReturn').val(),
                endDate = $('#endDateReturn').val(),
                keyword = $('#searchDataReturn').val();
                if(keyword == ''){
                    keyword = '0';
                } 
                // alert(fromDate);
            funcDataReturn(keyword, fromDate, endDate);
        });
        
        $("#endDateReturn").change(function(){
            let fromDate = $('#fromDateReturn').val(),
                endDate = $('#endDateReturn').val(),
                keyword = $('#searchDataReturn').val();
                if(keyword == ''){
                    keyword = '0';
                }
                
            funcDataReturn(keyword, fromDate, endDate);
        });

        $("#searchDataReturn").keyup(function (e) {
            e.preventDefault();
            clearTimeout(timer_cari_return); 
            timer_cari_return = setTimeout(function(){
                let keyword = $("#searchDataReturn").val().trim(),
                    fromDate = $('#fromDateReturn').val(),
                    endDate = $('#endDateReturn').val();

                if(keyword == ''){
                    keyword = '0';
                }
            funcDataReturn(keyword, fromDate, endDate)},700)
        });
        // let passAdminVal = document.getElementById("passAdmin");
        // q_select.oninput = function() {
        //     let fromDate = $('#fromDateReturn').val(),
        //         endDate = $('#endDateReturn').val(),
        //         passAdmin = document.getElementById("passAdmin").value;
        //         keyword = $('#searchDataReturn').val();
        //         if(keyword == ''){
        //             keyword = '0';
        //         }
        //     funcDataReturn(keyword, fromDate, endDate, passAdmin);
        // };
    });

    function funcDataReturn(keyword, fromDate, endDate){ 
        // alert(fromDate);
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/buttonAction/dataReturn/searchDataReturn/"+keyword+"/"+fromDate+"/"+endDate,
            success : function(response){
                $("#divDataReturn").html(response);
            }
        });
    }
    
</script>