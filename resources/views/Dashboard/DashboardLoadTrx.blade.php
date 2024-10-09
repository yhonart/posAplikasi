<?php
    $sumRecord = '0';
?>
<div class="row">
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
<div class="row">
    <div class="col-12">
        <div id="tableDataOnClick"></div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Garp Penjualan
            </h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div id="container"></div>
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-12 col-md-6">
        <div class="row">
            <div class="col-12">
                <button class="btn bg-indigo m-1 elevation-1 btn-flat" id="btnLap1"><i class="fa-solid fa-file-pdf"></i> Laporan Kasir</button>
                <button class="btn bg-indigo m-1 elevation-1 btn-flat" id="btnLap2"><i class="fa-solid fa-file-pdf"></i> Ringkasan Laporan Kasir</button>
                <button class="btn bg-success m-1 elevation-1 btn-flat" id="btnLapxls"><i class="fa-solid fa-file-excel"></i> Laporan Harian excel</button>
            </div>
            <div class="col-12">
                <div class="card bg-info">
                    <div class="card-body">
                        <p>Dashboard ini dapat menyesuaikan user. Infokan kepada kami apabila ada kebutuhan dalam menampilkan data dashboard</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
    
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Data Penjualan Per Bulan June-2024',
            align: 'left'
        },
        xAxis: {
            categories: [                
                @foreach($garpPenjualan as $xAxisDate)
                    '{{$xAxisDate->date_trx}}',
                @endforeach
            ],
            crosshair: true,
            accessibility: {
                description: 'Countries'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Pendapatan'
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'Total',
                data: [
                    @foreach($garpPenjualan as $ySeriesData1)
                        {{$ySeriesData1->totalPayment}},
                    @endforeach
                ]
            }
        ]
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
        
        
    });

</script>