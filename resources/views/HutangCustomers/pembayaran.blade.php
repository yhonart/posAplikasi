<div class="row">
    <div class="col-md-12 kolomFilter">
        <p class="text-muted">* Pilih nama pelanggan untuk input pembayaran hutang</p>
    </div>
</div>
<div class="row kolomFilter">
    <div class="col-6 col-md-3">
        <div class="form-group">
            <label class="form-label">Cari Nama Pelanggan</label>
            <select class="form-control select-pelanggan" id="cariNamaPelanggan" class="form-control ">
                <option value="0" readonly>Nama Pelanggan</option>
                @foreach($dbMCustomer as $dcs)
                <option value="{{$dcs->idm_customer }}">{{$dcs->customer_store}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="form-group">
            <label class="form-label">Dari Tanggal</label>
            <input type="text" class="form-control datetimepicker-input" name="dariTanggal" id="dariTanggal">
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="form-group">
            <label class="form-label">s.d Tanggal</label>
            <input type="text" class="form-control datetimepicker-input roundedd-0" name="sampaiTanggal" id="sampaiTanggal">
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <div id="reloadDisplay" style="display: none;">
            <div class="spinner-grow text-dark spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <span>Please Wait ....</span>
        </div>
    </div>
</div>
<div id="divDataPelunasan"></div>
<div class="row">
    <div class="col-md-12">
        <a href="{{asset('public/Document/ManualBookPembayaranHutang.pdf')}}" class="btn bg-light border-0" target="_blank">Dokumentasi Penggunaan.</a>
    </div>
</div>
<script>
    $(function() {
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        // $('#cariNamaPelanggan').focus();
        $('.datetimepicker-input').datepicker("setDate",new Date());
        $('#cariNamaPelanggan').select2({
            theme: 'bootstrap4',
        });
        dataPinjaman();
    });

    $(document).ready(function() {
        let fromDate = $('#dariTanggal').val(),
            endDate = $('#sampaiTanggal').val(),
            valAction = 1,
            keyWord = $("#cariNamaPelanggan").find(":selected").val();
            timer_cari_member = null;
        
        $("#cariNamaPelanggan").change(function(){
            let keyWord = $(this).find(":selected").val();
                fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val();
            $(".kolomFilter").hide("slow");
            searchData(keyWord, fromDate, endDate, valAction);
        });
        
        $("#dariTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                keyWord = $("#cariNamaPelanggan").find(":selected").val();

                if(keyWord == ''){
                    keyWord = '0';
                }                
            searchData(keyWord, fromDate, endDate,valAction);
        });

        $("#sampaiTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),                
                keyWord = $("#cariNamaPelanggan").find(":selected").val();
                if(keyWord == ''){
                    keyWord = '0';
                }
                
            searchData(keyWord, fromDate, endDate, valAction);
        });
        

        function searchData(keyWord, fromDate, endDate, valAction){  
            $("#reloadDisplay").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPelunasan/funcData/"+keyWord+"/"+fromDate+"/"+endDate+"/"+valAction,
                success : function(response){
                    $("#reloadDisplay").fadeOut("slow");
                    $("#divDataPelunasan").html(response);
                }
            });
        }
    });
    function dataPinjaman(){
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/buttonAction/dataPelunasan/listDataPinjaman",
            success : function(response){
                $("#divDataPelunasan").html(response);
            }
        });
    }
</script>