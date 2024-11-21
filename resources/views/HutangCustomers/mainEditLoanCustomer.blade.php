<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Data Pinjaman & Pelunasan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">                
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                           <select name="actionCode" id="actionCode" class="from-control form-control-sm">
                            <option value="0">Pilih Proses </option>
                            <option value="1">Pembayaran Hutan</option>
                            <option value="2">Open Transaksi Hutang</option>
                            <option value="3">Edit Limit Hutang</option>
                           </select>
                        </div>
                    </div>                    
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Cari</label>
                            <select class="form-control form-control-sm" id="cariNamaPelanggan" class="form-control form-control-sm select-pelanggan">
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
                            <input type="text" class="form-control datetimepicker-input  from-control-sm" name="dariTanggal" id="dariTanggal">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">s.d Tanggal</label>
                            <input type="text" class="form-control datetimepicker-input roundedd-0 form-control-sm" name="sampaiTanggal" id="sampaiTanggal">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="divDataPelunasan"></div>
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
        // $('#cariNamaPelanggan').focus();
        $('.datetimepicker-input').datepicker("setDate",new Date());
        $('#cariNamaPelanggan').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modal-global-large')
        });
        dataPinjaman();
    });
    
    $(document).ready(function() {
        let fromDate = $('#dariTanggal').val(),
            endDate = $('#sampaiTanggal').val(),
            valAction = $("#actionCode").val(),
            keyWord = $("#cariNamaPelanggan").find(":selected").val();
            timer_cari_member = null;
        
        $("#cariNamaPelanggan").change(function(){
            let keyWord = $(this).find(":selected").val();
            fromDate = $('#dariTanggal').val(),
            endDate = $('#sampaiTanggal').val(),
            
            searchData(keyWord, fromDate, endDate, valAction);
        })
        
        
        $("#dariTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                valAction = $("#actionCode").val(),
                keyWord = $("#cariNamaPelanggan").find(":selected").val();
                if(keyWord == ''){
                    keyWord = '0';
                }                
            searchData(keyWord, fromDate, endDate,valAction);
        });

        $("#sampaiTanggal").change(function(){
            let fromDate = $('#dariTanggal').val(),
                endDate = $('#sampaiTanggal').val(),
                valAction = $("#actionCode").val(),
                keyWord = $("#cariNamaPelanggan").find(":selected").val();
                if(keyWord == ''){
                    keyWord = '0';
                }
                
            searchData(keyWord, fromDate, endDate, valAction);
        });
        

        function searchData(keyWord, fromDate, endDate, valAction){  
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPelunasan/funcData/"+keyWord+"/"+fromDate+"/"+endDate+"/"+valAction,
                success : function(response){
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