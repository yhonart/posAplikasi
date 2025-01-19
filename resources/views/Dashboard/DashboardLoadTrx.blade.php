<?php
    $sumRecord = '0';
?>
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
        <div class="form-group row">
            <div class="col-md-6">
                <select name="pilihTahun" id="pilihTahun" class="form-control form-control-sm">
                    @foreach($selectYear as $sy)
                        <option value="{{$sy->years}}">{{$sy->years}}</option>
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaksi Per Kasir</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
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
                        @endforeach
                    </tbody>
                </table>
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