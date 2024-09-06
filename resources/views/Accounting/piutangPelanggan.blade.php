@extends('layouts.sidebarpage')

@section('content')
<!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-8 col-12">          
                        <h1 class="m-0">Piutang Pelanggan</h1>
                    </div>          
                </div>
            </div>
        </div>
    <!-- content -->
    <div class="content mt-0">
        <div class="container-fluid">
            @if($checkArea <> 0).
            <div class="row">
                <div class="col-12">
                   <div class="card card-body">
                       <p class="border border-info p-3 rounded-lg font-weight-bold text-info bg-light">*Pilih nama pelanggan untuk input pembayaran kredit</p>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Cari Nama Pelanggan</label>
                                    <select class="form-control form-control-sm" id="cariNamaPelanggan" class="form-control form-control-sm select-pelanggan">
                                        <option value="0" readonly>Semua Transaksi</option>
                                        @foreach($dbMCustomer as $dcs)
                                        <option value="{{$dcs->idm_customer }}">{{$dcs->customer_store}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Dari Tanggal</label>
                                    <input type="text" class="form-control datetimepicker-input rounded-0" name="dariTanggal" id="dariTanggal" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">s.d Tanggal</label>
                                    <input type="text" class="form-control datetimepicker-input rounded-0" name="sampaiTanggal" id="sampaiTanggal" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <div id="divDataPelunasan"></div>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
            @else
                <div class="row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="alert alert-warning alert-dismissible text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            <span class="font-weight-bold">
                                User anda belum memiliki hak akses dikarenakan belum di setup area kerjanya, silahkan hubungi administrator untuk lebih lanjutnya!
                            </span>
                        </div>                        
                    </div>
                </div>
            @endif
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
        // $('.datetimepicker-input').datepicker("setDate",new Date());
        $('#cariNamaPelanggan').select2({
            theme: 'bootstrap4'
        });
        dataPinjaman();
    });
    
    $(document).ready(function() {
        let fromDate = $('#dariTanggal').val(),
            endDate = $('#sampaiTanggal').val(),
            keyWord = $("#cariNamaPelanggan").find(":selected").val();
            timer_cari_member = null;
        
        $("#cariNamaPelanggan").change(function(){
            let keyWord = $(this).find(":selected").val();
            fromDate = $('#dariTanggal').val(),
            endDate = $('#sampaiTanggal').val();
            
            if (fromDate == ''){
                fromDate = '0';
            }
            if (endDate == ''){
                endDate = '0';
            }
            searchData(keyWord, fromDate, endDate);
        })
        
        // $("#dariTanggal").change(function(){
        //     let fromDate = $('#dariTanggal').val(),
        //         endDate = $('#sampaiTanggal').val(),
        //         keyWord = $("#cariNamaPelanggan").find(":selected").val();
        //         if(keyWord == ''){
        //             keyWord = '0';
        //         }                
        //     searchData(keyWord, fromDate, endDate);
        // });

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
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPelunasan/funcData/"+keyWord+"/"+fromDate+"/"+endDate,
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
@endsection