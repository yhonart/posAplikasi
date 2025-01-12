<div class="card card-body">
    <div class="row">
        <div class="col-md-12">
            <p>* Range Tanggal Dalam 1 Minggu</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3" style="display: none;">
            <div class="form-group">
                <label for="namaKasir" class="label">Kasir</label>
                <select name="namaKasir" id="namaKasir" class="form-control form-control-sm">
                    <option value="0">====</option>
                    @foreach($userKasir as $uk)
                        <option value="{{$uk->name}}">{{$uk->name}}</option>
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
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        function getMonday(d) {
            d = new Date(d);
            var day = d.getDay(),
                diff = d.getDate() - day + (day == 0 ? -6 : 1); // adjust when day is sunday
            return new Date(d.setDate(diff));
        }

        var curr = getMonday(new Date());
        var first = curr.getDate() - curr.getDay();
        var last = first + 7;
        var firstDate = new Date(curr.setDate(first));
        var lastDate = new Date(curr.setDate(last));

        $('#dariTanggal').datepicker("setDate",firstDate);
        $('#sampaiTanggal').datepicker("setDate",lastDate);
        
        $('#namaKasir').select2({
            theme: 'bootstrap4',
        });
    });
    

    $(document).ready(function(){
        let kasir = $("#namaKasir").val(),
            fromDate = $("#dariTanggal").val(),
            endDate = $("#sampaiTanggal").val();

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
                url : "{{route('kasBesar')}}/tableLaporan/"+kasir+"/"+fromDate+"/"+endDate,
                success : function(response){
                    $('#tableFilter').html(response);
                }
            });
        }

    });
</script>