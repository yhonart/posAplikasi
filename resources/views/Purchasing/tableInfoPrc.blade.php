<div class="row" id="cardInfoPembelian" style="display:none;">
    <div class="col-12 col-md-3">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Pembelian Belum Dibayar</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-2"><i class="fa-solid fa-rupiah-sign"></i></div>
                    <div class="col-10 text-right">
                        <h6 class="text-danger font-weight-bold">
                            {{number_format($sumHutang->totalTunai,'0',',','.')}}
                        </h6>
                        <a href="#" class="text-success font-weight-bold text-center el-zoom filter-info" data-display="Bayar">Bayar <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">Pembelian Jatuh Tempo</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-2"><i class="fa-solid fa-rupiah-sign"></i></div>
                    <div class="col-10 text-right">
                        <h6 class="text-danger font-weight-bold">
                            <?php
                                $jumlah = '0';
                                foreach($doDate as $dd){
                                    if($dd->jumlahHari > $dd->tempo){
                                        $jumlah += $dd->sub_total;
                                    }
                                }
                                echo number_format($jumlah,'0',',','.');
                            ?>
                        </h6>
                        <a href="#" class="text-success font-weight-bold text-center el-zoom filter-info" data-display="DueDate">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">Pelunasan 30 Hari Terakhir</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-2"><i class="fa-solid fa-rupiah-sign"></i></div>
                    <div class="col-10">
                        <h6 class="text-danger font-weight-bold">{{number_format($sum30Ago->totalTunai,'0',',','.')}}</h6>
                        <a href="#" class="text-success font-weight-bold text-center el-zoom filter-info" data-display="lastPayment">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">Pembayaran Tunai/Transfer</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-2"><i class="fa-solid fa-rupiah-sign"></i></div>
                    <div class="col-10">
                        <h6 class="text-success font-weight-bold">{{number_format($sumTunai->totalTunai,'0',',','.')}}</h6>
                        <a href="#" class="text-success font-weight-bold text-center el-zoom filter-info" data-display="Payed">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="rowFilter" style="display:none;">
    <div class="col-12">
        <div id="tableFilter"></div>
    </div>
</div>

<div class="row mb-2" id="filteringData">
    <div class="col-md-3">
        <div class="form-group">
            <label for="fromDate" class="label">Dari Tanggal</label>
            <input type="text" class="form-control form-control-sm datetimepicker-input" name="fromDate" id="fromDate" value="0">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="fromDate" class="label">S.d Tanggal</label>
            <input type="text" class="form-control form-control-sm datetimepicker-input" name="endDate" id="endDate" value="0">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status" class="label">Status Dok.</label>
            <select name="status" id="status" class="form-control form-control-sm">
                <option value="2">Submited</option>
                <option value="1">Sedang Proses</option>
                <option value="0">Dihapus</option>
                <option value="3">Disetujui</option>
            </select>
        </div>
    </div>
</div>

<div class="row" id="tablePembelian">
    <div class="col-12">
        <div id="custom-purchase-data" role="tabpanel"></div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(function(){
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        $('.datetimepicker-input').datepicker("setDate",new Date());

        let appData = "tablePenerimaan",
            status = "2",
            fromDate = '0',
            endDate = '0';
        viewDisplayPurchasing(appData,status,fromDate,endDate);
    })
    
    $('.display-onclick').click(function(){
        let el = $(this),
            status = "1",
            fromDate = $("#fromDate").val(),
            endDate = $("#endDate").val();
        let appData = el.attr("data-display");
        viewDisplayPurchasing(appData,status,fromDate,endDate);
    });
    
    $('.filter-info').click(function(){
        let el = $(this);
        let appFilter = el.attr("data-display");
        displayPanelFilter(appFilter);
    });

    $("#status").change(function(){
        let status = $(this).find(":selected").val(),
            fromDate = $("#fromDate").val(),
            endDate = $("#endDate").val(),
            appData = "tablePenerimaan";
            
        viewDisplayPurchasing(appData,status,fromDate,endDate);
    });

    $("#fromDate").change(function(){
        let status = $("#status").find(":selected").val(),
            fromDate = $("#fromDate").val(),
            endDate = $("#endDate").val(),
            appData = "tablePenerimaan";

        viewDisplayPurchasing(appData,status,fromDate,endDate);
    });

    $("#endDate").change(function(){
        let status = $("#status").find(":selected").val(),
            fromDate = $("#fromDate").val(),
            endDate = $("#endDate").val(),
            appData = "tablePenerimaan";

        viewDisplayPurchasing(appData,status,fromDate,endDate);
    });
    
    function viewDisplayPurchasing(appData,status,fromDate,endDate){
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/"+appData+"/"+status+"/"+fromDate+"/"+endDate,
            success : function(response){
                $('#custom-purchase-data').html(response);
            }
        });
    }
    
    function displayPanelFilter(appFilter){
        $("#tablePembelian").fadeOut();
        $("#filteringData").fadeOut();
        $("#rowFilter").show();
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/"+appFilter,
            success : function(response){
                $('#tableFilter').html(response);
            }
        });
    }
    
</script>