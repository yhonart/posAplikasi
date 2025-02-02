<?php
    $sumRecord = '0';
    $sumPendapatan = 0;
?>
<div class="row mb-2">
    <div class="col-md-12">
        <div class="alert alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-info"></i> Alert!</h5>
            <p> <img src="{{asset('public/images/Animation - 1738511387784.gif')}}" height="60" width="60"> Sudah hari <b>Senin</b> nih, jangan lupa  masukkan Reimbursement / Pengembalian Dana Kas.
            Klik link berikut ini untuk input nominal pengembalian dana kas</p>
            <a href="{{route('trxReumbers')}}">Reimbursement / Pengembalian Dana Kas</a>
        </div>
    </div>
</div>
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
        <div class="card card-info card-tabs">
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
        <div class="card card-info card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="tabs-one-penjualan-tab" data-toggle="pill" href="#tabs-one-penjualan" role="tab" aria-controls="tabs-one-penjualan" aria-selected="true">Penjualan Kasir</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="tabs-two-hutang-customer-tab" data-toggle="pill" href="#tabs-two-hutang-customer" role="tab" aria-controls="tabs-two-hutang-customer" aria-selected="false">Hutang Pelanggan</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="tabs-three-pembelian-tab" data-toggle="pill" href="#tabs-three-pembelian" role="tab" aria-controls="tabs-three-pembelian" aria-selected="false">Pembelian Toko</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="tabs-one-penjualan" role="tabpanel" aria-labelledby="tabs-one-penjualan-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Kasir</th>
                                            <th>Total Penerimaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($penjualan as $p)
                                            <tr>
                                                <td>{{date("d-M-y", strtotime($p->date_trx))}}</td>
                                                <td>{{$p->created_by}}</td>
                                                <td class="text-right">{{number_format($p->paymentCus,'0',',','.')}}</td>
                                            </tr>
                                            <?php
                                                $sumPendapatan +=$p->paymentCus
                                            ?>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="font-weight-bold text-right">{{number_format($sumPendapatan,'0',',','.')}}</td>
                                        </tr>
                                    </tbody>
                                </table>                               
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-two-hutang-customer" role="tabpanel" aria-labelledby="tabs-two-hutang-customer-tab">
                        On Progress
                    </div>
                    <div class="tab-pane fade" id="tabs-three-pembelian" role="tabpanel" aria-labelledby="tabs-three-pembelian-tab">
                        On Progress
                    </div>
                </div>                
            </div>
        </div>
    </div> 
</div>

<script>
    $(function() {
        let selectYear1 = $("#pilihTahun").val();
        $.ajax({ 
            type : 'get', 
            url : "{{route('Dashboard')}}/garphPembelian/"+selectYear1,              
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
        $("#pilihTahun").change(function(){
            let selectYear2 = $(this).find(":selected").val();
            $.ajax({ 
                type : 'get', 
                url : "{{route('Dashboard')}}/garphPembelian/"+selectYear2,              
                success : function(response){
                    $('#pembelianVsPenjualan').html(response);
                } 
            });
        });
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