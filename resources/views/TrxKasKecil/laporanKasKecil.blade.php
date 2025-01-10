<div class="card card-body">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="namaKasir" class="label">Kasir</label>
                <select name="namaKasir" id="namaKasir" class="form-control form-control-sm">
                    <option value="0">====</option>
                    @foreach($userKasir as $uk)
                        <option value="{{$uk->id}}">{{$uk->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="dariTanggal" class="label">Dari Tanggal</label>
                <input type="text" class="form-control datetimepicker-input" name="dariTanggal" id="dariTanggal">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="sampaiTanggal" class="label">Sampai Tanggal</label>
                <input type="text" class="form-control datetimepicker-input roundedd-0" name="sampaiTanggal" id="sampaiTanggal">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div id="tableFilter"></div>
        </div>
    </div>
</div>

<script>
    $(function(){
        // $( ".datetimepicker-input" ).datepicker({
        //     dateFormat: 'yy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true,
        // });
        // $('.datetimepicker-input').datepicker("setDate",new Date());
        
    });
    $(function() {
        $('input[name="dariTanggal"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
    $('#namaKasir').select2({
        theme: 'bootstrap4',
    });

    $(document).ready(function(){
        let kasir = $("#namaKasir").val(),
            fromDate = 0,
            endDate = 0;

        tableAP(kasir, fromDate, endDate);
        
        $("#namaKasir").change(function(){
            let kasir = $(this).val(),
                fromDate = $("#dariTanggal").val(),
                endDate = $("#sampaiTanggal").val();
                tableAP(kasir, fromDate, endDate);
        });
        $("#dariTanggal").change(function(){
            let kasir = $("#namaKasir").val(),
                fromDate = $(this).val(),
                endDate = $("#sampaiTanggal").val();
                tableAP(kasir, fromDate, endDate);
        });
        $("#sampaiTanggal").change(function(){
            let kasir = $("#namaKasir").val(),
                fromDate = $("#dariTanggal").val(),
                endDate = $(this).val();
                tableAP(kasir, fromDate, endDate);
        });

        function tableAP(kasir, fromDate, endDate){
            $.ajax({
                type : 'get',
                url : "{{route('kasKecil')}}/tableLaporan/"+kasir+"/"+fromDate+"/"+endDate,
                success : function(response){
                    $('#tableFilter').html(response);
                }
            });
        }

    });
</script>