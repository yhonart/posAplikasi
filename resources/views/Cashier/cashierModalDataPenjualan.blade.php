<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Data Penjualan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" class="form-control datetimepicker-input" id="datePenjualan" name="datePenjualan"/>                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="divDataPenjualan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $( function() {
        $( "#datePenjualan" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#datePenjualan').datepicker("setDate",new Date());
    } );

    $(document).ready(function(){
        let dateSelect = $('#datePenjualan').val();
        funcDataPenjualan(dateSelect);
        
        $("#datePenjualan").change(function(){
            let dateSelect = $('#datePenjualan').val();
            funcDataPenjualan(dateSelect);
        });
    });
    function funcDataPenjualan(dateSelect){        
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/buttonAction/dataPenjualan/funcData/"+dateSelect,
            success : function(response){
                $("#divDataPenjualan").html(response);
            }
        });
    }
    
</script>