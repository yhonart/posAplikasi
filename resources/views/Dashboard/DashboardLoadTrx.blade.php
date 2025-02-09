<?php
    $sumRecord = '0';
    $dayNoww = date('l', strtotime($hariIni));
    $strHari = "Monday";
?>
@if($dayNoww == $strHari AND $getInfoKas == '0')
<div class="row mb-2">
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5><img src="{{asset('public/images/Animation1738512688097.gif')}}" height="90" width="90"> Udah Hari <b>Senin</b> nih!</h5>
            <p>Jangan lupa masukkan Reimbursement / Pengembalian Dana Kas, untuk kebutuhan kas kecil anda. Klik link dibawah ini untuk memasukkan dana : </p>
            <a href="{{route('trxReumbers')}}" class="text-info font-weight-bold">Reimbursement / Pengembalian Dana Kas</a>
        </div>        
    </div>
</div>
@endif
<div class="row mb-2">
    <div class="col-lg-3 col-6">
        <a href="#" class="onClick-Data" data-condition="alltrx" data-from="{{$fromDate}}" data-end="{{$endDate}}">
            <div class="small-box bg-success">
              <div class="inner">
                <h4>Rp.{{number_format($lastTrxAll->totalAll,'0',',','.')}}</h4>
                <p>{{$countTransaksi}} Total Penjualan</p>
              </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="#" class="onClick-Data" data-condition="allSummery" data-from="{{$fromDate}}" data-end="{{$endDate}}">
            <div class="small-box bg-primary">
              <div class="inner">
                <h4>{{$totalTransaksi}}</h4>
                <p>Data Transaksi</p>
              </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="#" class="onClick-Data" data-condition="onprocess" data-from="{{$fromDate}}" data-end="{{$endDate}}">
            <div class="small-box bg-info">
              <div class="inner">
                <h4>{{$lastTrxonProcess}}</h4>
                <p>On Process</p>
              </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="#" class="onClick-Data" data-condition="kredit" data-from="{{$fromDate}}" data-end="{{$endDate}}">
            <div class="small-box bg-danger">
              <div class="inner">
                <h4>{{$lastTrxKredit}}</h4>
                <p>Total Kredit</p>
              </div>
            </div>
        </a>
    </div>    
</div>
<div class="row mb-2" style="display: none;">
    <div class="col-md-12">
        <div class="form-group row">
            <label for="0" class="col-md-3">Pilih Kasir</label>
            <div class="col-md-4">
                <select name="namaKasir" id="namaKasir" class="form-control">
                    <option value="0">===</option>
                    @foreach($userKasir as $uk)
                        <option value="{{$uk->name}}">{{$uk->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <div id="tableDataOnClick"></div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <button class="btn bg-indigo m-1 elevation-1 " id="btnLap1"><i class="fa-solid fa-file-pdf"></i> Laporan Kasir</button>
        <button class="btn bg-indigo m-1 elevation-1 " id="btnLap2"><i class="fa-solid fa-file-pdf"></i> Ringkasan Laporan Kasir</button>
        <button class="btn bg-success m-1 elevation-1 " id="btnLapxls"><i class="fa-solid fa-file-excel"></i> Laporan Harian excel</button>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-info card-tabs" style="height: 600px;">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Quartal</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Quartal Versus</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Tahunan</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <select name="pilihTahun" id="pilihTahun" class="form-control form-control-sm">
                                    @foreach($selectYear as $sy)
                                        <option value="{{$sy->years}}">{{$sy->years}}</option>
                                    @endforeach
                                </select>                                 
                            </div>
                            <div class="col-md-6">
                                <select name="pilihQuartal" id="pilihQuartal" class="form-control form-control-sm">
                                    @foreach($monthsByQuarter as $key => $quarter)
                                        <option value="{{ $key }}">{{ $quarter }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="pembelianVsPenjualan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        On Progress
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                        On Progress
                    </div>
                </div>
            </div>            
        </div>
    </div>  
    <div class="col-md-6">
        <div class="card card-info card-tabs" style="height: 600px;">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active on-menu-click" data-display="tablePenjualan" id="tabs-one-penjualan-tab" data-toggle="pill" href="#tabs-display-on-click" role="tab" aria-controls="tabs-one-penjualan" aria-selected="true">Penjualan Kasir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link on-menu-click" data-display="tableHutang" id="tabs-two-hutang-customer-tab" data-toggle="pill" href="#tabs-display-on-click" role="tab" aria-controls="tabs-two-hutang-customer" aria-selected="false">Hutang Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link on-menu-click" data-display="tablePembelian" id="tabs-three-pembelian-tab" data-toggle="pill" href="#tabs-display-on-click" role="tab" aria-controls="tabs-three-pembelian" aria-selected="false">Pembelian Toko</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0 table-responsive">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="tabs-display-on-click" role="tabpanel" aria-labelledby="tabs-one-penjualan-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="displayDataTransaction"></div>                                                              
                            </div>
                        </div>
                    </div>                    
                </div>                
            </div>
        </div>
    </div> 
</div>

<script>
    $(function() {
        let selectYear1 = $("#pilihTahun").val();
        let selectQuartal = $("#pilihQuartal").val();
        $.ajax({ 
            type : 'get', 
            url : "{{route('Dashboard')}}/garphPembelian/"+selectYear1+"/"+selectQuartal,              
            success : function(response){
                $('#pembelianVsPenjualan').html(response);
            } 
        });        
    });

    $("#btnLap1").click(function(){
        let fromdate = "{{$fromDate}}",
            enddate = "{{$endDate}}";
        window.open("{{route('Cashier')}}/buttonAction/trxReportDetailPdf/"+fromdate+"/"+enddate, "_blank");
    })
    $("#btnLap2").click(function(){
        let fromdate = "{{$fromDate}}",
            enddate = "{{$endDate}}";
        window.open("{{route('Cashier')}}/buttonAction/trxReportRecapPdf/"+fromdate+"/"+enddate, "_blank");
    })
    
    $("#btnLapxls").click(function(){
        let fromdate = "{{$fromDate}}",
            enddate = "{{$endDate}}";
        window.open("{{route('Cashier')}}/buttonAction/trxReportRecapExcel/"+fromdate+"/"+enddate, "_blank");
    })

    $(document).ready(function() {
        let display = "tablePenjualan",
            fromDate = "{{$fromDate}}",
            endDate = "{{$endDate}}";
        functionDisplayTable(display, fromDate, endDate);

        $("#pilihTahun").change(function(){
            let selectYear2 = $(this).find(":selected").val();
            let selectQuartal = $("#pilihQuartal").val();
            $.ajax({ 
                type : 'get', 
                url : "{{route('Dashboard')}}/garphPembelian/"+selectYear2+"/"+selectQuartal,              
                success : function(response){
                    $('#pembelianVsPenjualan').html(response);
                } 
            });
        });

        $("#pilihQuartal").change(function(){
            let selectYear2 = $("#pilihQuartal").val();
            let selectQuartal = $(this).find(":selected").val();
            $.ajax({ 
                type : 'get', 
                url : "{{route('Dashboard')}}/garphPembelian/"+selectYear2+"/"+selectQuartal,              
                success : function(response){
                    $('#pembelianVsPenjualan').html(response);
                } 
            });
        });

        $(".on-menu-click").click(function(e){
            e.preventDefault();
            let display = $(this).attr("data-display"),
                fromDate = "{{$fromDate}}",
                endDate = "{{$endDate}}";      
                
            functionDisplayTable(display, fromDate, endDate);
            
        });

        function functionDisplayTable(display, fromDate, endDate){
            $.ajax({ 
                type : 'get', 
                url : "{{route('Dashboard')}}/displayOnTable/"+display+"/"+fromDate+"/"+endDate,              
                success : function(response){
                    $('#displayDataTransaction').html(response);
                } 
            });
        }
    });
    
    $(document).ready(function(){
        $(".onClick-Data").click(function(){
            var el = $(this) ;
            let condition = el.attr("data-condition"),
                fromDate = el.attr("data-from"),
                endDate = el.attr("data-end");
            
            $.ajax({ 
                type : 'post', 
                url : "{{route('Dashboard')}}/loadDataTransaksi/postOnClick", 
                data :  {condition:condition, fromDate:fromDate, endDate:endDate}, 
                success : function(response){
                    $('#tableDataOnClick').html(response);
                } 
            });
        });     
        
        $("#namaKasir").change(function(){
            let namaKasir = $(this).val();
            let fromdate = "{{$fromDate}}",
                enddate = "{{$endDate}}";

            $.ajax({ 
                type : 'get', 
                url : "{{route('Dashboard')}}/loadDataTransaksi/getTrxByKasir/"+namaKasir+"/"+fromdate+"/"+enddate,
                success : function(response){
                    $('#tableDataOnClick').html(response);
                } 
            });
        });
        
    });

</script>