<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="supName" class="label">Supplier</label>
            <select name="supName" id="supName" class="form-control form-control-sm">
                <option value="0">====</option>
                @foreach($mSupplier as $msup)
                <option value="{{$msup->idm_supplier}}">{{$msup->store_name}}</option>
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

<script>
    $(function(){
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
        
        $('#supName').select2({
            theme: 'bootstrap4',
        });

        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/Bayar",
            success : function(response){
                $('#tableFilter').html(response);
            }
        });
    });
</script>