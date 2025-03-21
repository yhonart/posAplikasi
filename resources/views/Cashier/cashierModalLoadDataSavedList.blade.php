<?php
    use Illuminate\Support\Facades\Auth;
    $no = '0';
    $arayStatus = array(
        0=>"Deleted",
        1=>"Proses",
        2=>"Hold",
        3=>"Tempo",
        4=>"Selesai Bayar"
    );
    $arayBadge = array(
        0=>"badge-danger",
        1=>"badge-info",
        2=>"badge-warning",
        3=>"badge-succes",
        4=>"badge-succes"
    );
    $hakakses = Auth::user()->hakakses;
?>
<p id="notifAction"></p>
<table class="table table-sm table-hover table-valign-middle table-hover">
    <thead>
        <tr>
            <th>No.Transaksi</th>
            <th>Pelanggan</th>
            <th>Total Item</th>
            <th>Total</th>
            <th>Kasir</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataSaved as $dS2)
            <tr>
                <td class="font-weight-bold">
                    <a class="text-info load-transaksi" href="#" data-id="{{$dS2->billing_number}}">
                        {{$dS2->billing_number}}
                    </a>
                </td>
                <td class="font-weight-bold">
                    {{$dS2->customer_store}}
                </td>
                <td>{{$dS2->t_item}}</td>
                <td>{{number_format($dS2->t_bill,'0',',','.')}}</td>
                <td>{{$dS2->created_by}}</td>
                <td>
                    <span class="badge {{$arayBadge[$dS2->status]}}">{{$arayStatus[$dS2->status]}}</span>
                </td>
                <td>
                    <button class="btn btn-danger btn-sm elevation-1 btnDel" data-trx="{{$dS2->billing_number}}">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    
    $(document).ready(function(){
        $(".load-transaksi").click(function(){
            var element = $(this) ;
            var data = element.attr("data-id");
            let routeIndex = "{{route('Cashier')}}",
                urlProductList = "productList",
                panelProductList = $("#mainListProduct"),
                urlButtonForm = "buttonAction",
                panelButtonForm = $("#mainButton"),
                trxType = '1';
            $.ajax({
                type : "get",
                url: "{{route('Cashier')}}/buttonAction/dataPenjualan/selectData/"+data+ "/"+trxType ,
                success: function(response) {                    
                    window.location.reload();
                }
            })
        });
        
        $(".btnDel").click(function(){
            let el = $(this);
            let dataTrx = el.attr("data-trx");
            let fromDate = "{{$fromDate}}",
                endDate = "{{$endDate}}";
            alertify.confirm("Apakah anda yakin ingin menghapus transaksi ini?",
                function(){
                    $.ajax({
                        type : "get",
                        url: "{{route('Cashier')}}/buttonAction/deleteHoldData/"+dataTrx,
                        success: function(response) {    
                            funcLoadSuccess(fromDate, endDate)                
                            // window.location.reload();
                        }
                    })
                },
                function(){
                    alertify.error('Cancel');
                }).set({title:"Notifikasi"});
        });
        
        function funcLoadSuccess(fromDate, endDate){        
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPenjualan/tampilData/"+fromDate+"/"+endDate,
                success : function(response){
                    $(".tampilDataSimpan").html(response);
                }
            });
        }
        
    });
</script>