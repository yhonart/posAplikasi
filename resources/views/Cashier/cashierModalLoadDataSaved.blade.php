<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Load Data Yang Tersimpan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p><i class="fa-solid fa-circle-info"></i> Klik pada nomor transaksi untuk melakukan load transaksi.</p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm datetimepicker-input rounded-0" id="fromDate" name="fromDate"/>
                        </div>
                    </div>                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm datetimepicker-input rounded-0" id="endDate" name="endDate"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tampilDataSimpan"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-warning btn-sm font-weight-bold elevation-2" id="btnCloseModal"><i class="fa-solid fa-xmark font-weight-bold"></i> Close</button>
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
        let dateData = $('#pilihTanggal').val();
        functLoadData(dateData);
        
        $("#pilihTanggal").change(function(){
            let dateData = $('#pilihTanggal').val();
            functLoadData(dateData);
        });
        function functLoadData(dateData){        
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPenjualan/tampilData/"+dateData,
                success : function(response){
                    $(".tampilDataSimpan").html(response);
                }
            });
        }
        $("#btnCloseModal").on('click', function(){
            window.location.reload();
        });
    });
</script>