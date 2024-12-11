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
    <div class="col-12">
        <div class="card card-body border-info">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn bg-indigo m-1 elevation-1 " id="btnLap1"><i class="fa-solid fa-file-pdf"></i> Laporan Kasir</button>
                    <button class="btn bg-indigo m-1 elevation-1 " id="btnLap2"><i class="fa-solid fa-file-pdf"></i> Ringkasan Laporan Kasir</button>
                    <button class="btn bg-success m-1 elevation-1 " id="btnLapxls"><i class="fa-solid fa-file-excel"></i> Laporan Harian excel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="pilihTahun" id="pilihTahun" class="form-control form-control-sm">
                            @foreach($selectYear as $sy)
                                <option value="{{$sy->years}}">{{$sy->years}}</option>
                            @endforeach
                        </select>    
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="pembelianVsPenjualan"></div>
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
        
        
    });

</script>