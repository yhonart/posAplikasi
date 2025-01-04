<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan All Customers</h3>
    </div>
    <div class="card-body">
        <div class="row">
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
        <div class="row">
            <div class="col-md-12">
                <div id="displayLaporanCustomer"></div>
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
        // $('#cariNamaPelanggan').focus();
        $('.datetimepicker-input').datepicker("setDate",new Date());
        $('#cariNamaPelanggan').select2({
            theme: 'bootstrap4',
        });
    });

    $(document).ready(function() {
        let fromDate = 0,
            endDate = 0,
            keyWord = 0,
            timer_cari_member = null;
        
        searchData(keyWord, fromDate, endDate);
        
        $("#cariNamaPelanggan").change(function(){
            let keyWord = $(this).find(":selected").val();
                fromDate = 0,
                endDate = 0;

            searchData(keyWord, fromDate, endDate);
        });
        
        $("#dariTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                keyWord = $("#cariNamaPelanggan").find(":selected").val();

                if(keyWord == ''){
                    keyWord = '0';
                }                
            searchData(keyWord, fromDate, endDate);
        });

        $("#sampaiTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),                
                keyWord = $("#cariNamaPelanggan").find(":selected").val();
                if(keyWord == ''){
                    keyWord = '0';
                }
                
            searchData(keyWord, fromDate, endDate);
        });
        

        function searchData(keyWord, fromDate, endDate){  
            $("#reloadDisplay").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('adminPiutangPelanggan')}}/laporanCustomer/"+keyWord+"/"+fromDate+"/"+endDate,
                success : function(response){
                    $("#reloadDisplay").fadeOut("slow");
                    $("#displayLaporanCustomer").html(response);
                }
            });
        }
    });
</script>