<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">History Pembayaran</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="supNameHistory" class="label">Supplier</label>
                    <select name="supNameHistory" id="supNameHistory" class="form-control form-control-sm">
                        <option value="0">====</option>
                        @foreach($mSupplier as $msup)
                        <option value="{{$msup->idm_supplier}}">{{$msup->store_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="formDateHistory" class="label">Dari Tanggal</label>
                    <input type="text" class="form-control datetimepicker-input" name="formDateHistory" id="formDateHistory">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="endDateHistory" class="label">Sampai Tanggal</label>
                    <input type="text" class="form-control datetimepicker-input roundedd-0" name="endDateHistory" id="endDateHistory">
                </div>
            </div>
            <div class="col-md-3">
                <div class="from-group">
                    <label for="status" class="label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="0">All</option>
                        <option value="1">Lunas</option>
                        <option value="2">Outstanding</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div id="tableFilterHistory"></div>
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
        
        $('#supNameHistory').select2({
            theme: 'bootstrap4',
        });

    });

    $(document).ready(function(){
        let supplier = $("#supNameHistory").val(),
            fromDate = 0,
            endDate = 0,
            status = 0;

        tableAP(supplier, fromDate, endDate, status);
        
        $("#supNameHistory").change(function(){
            let supplier = $(this).val(),
                fromDate = $("#formDateHistory").val(),
                endDate = $("#endDateHistory").val(),
                status = $("#status").val();
                tableAP(supplier, fromDate, endDate, status);
        });
        $("#formDateHistory").change(function(){
            let supplier = $("#supNameHistory").val(),
                fromDate = $(this).val(),
                endDate = $("#endDateHistory").val(),
                status = $("#status").val();
                tableAP(supplier, fromDate, endDate, status);
        });
        $("#endDateHistory").change(function(){
            let supplier = $("#supNameHistory").val(),
                fromDate = $("#formDateHistory").val(),
                endDate = $(this).val(),
                status = $("#status").val();
                tableAP(supplier, fromDate, endDate, status);
        });

        function tableAP(supplier, fromDate, endDate, status){
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/historyPembayaran/filtering/"+supplier+"/"+fromDate+"/"+endDate+"/"+status,
                success : function(response){
                    $('#tableFilterHistory').html(response);
                }
            });
        }

    });
</script>