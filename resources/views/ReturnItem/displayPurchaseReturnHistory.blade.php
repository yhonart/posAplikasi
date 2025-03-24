
<?php
$arrStatus = array(
    0=>"Batal",
    1=>"Dalam Proses",
    2=>"Di Periksa",
    3=>"Di Setujui",
    4=>"Sudah Digunakan"
);
$arrBgStatus = array(
    0=>"bg-danger",
    1=>"bg-warning",
    2=>"bg-info",
    3=>"bg-success",
    4=>"bg-primary"
);
?>
<div class="card card-purple">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">History Return</h3>
    </div>
    <div class="card-body">
        <table class="table table-valign-middle table-hover table-sm text-sm">
            <thead>
                <tr>
                    <th>Dok.Number</th>
                    <th>Supplier</th>
                    <th>Purchase Number</th>
                    <th class="text-right">Point Belanja</th>
                    <th class="text-right">Status</th>
                    <th class="text-right">#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historyReturn as $hisReturn)
                    <tr>
                        <td>{{$hisReturn->return_number}}</td>
                        <td>{{$hisReturn->store_name}}</td>
                        <td>
                            @if($hisReturn->purchase_number == '0')
                                Retur Non Invoice.
                            @else
                                {{$hisReturn->purchase_number}}
                            @endif
                        </td>
                        <td class="text-right">{{number_format($hisReturn->price,'0',',','.')}}</td>
                        <td class="text-right">
                            <span class="badge {{$arrBgStatus[$hisReturn->status]}}">{{$arrStatus[$hisReturn->status]}}</span>                            
                        </td>
                        <td class="text-right">
                            @if($hisReturn->status == '2')
                                <button type="button" class="btn btn-sm btn-success BTN-APPROVE font-weight-bold" data-purchase="{{$hisReturn->purchase_number}}" data-return = "{{$hisReturn->return_number}}"><i class="fa-solid fa-check"></i></button>
                            @endif
                            <button type="button" class="btn btn-sm btn-primary BTN-DETAIL font-weight-bold" data-purchase="{{$hisReturn->purchase_number}}" data-return = "{{$hisReturn->return_number}}"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".BTN-DETAIL").on('click', function (e) {
            e.preventDefault();
            let el = $(this),
                purchaseReturn = el.attr('data-purchase'),
                dataReturn = el.attr('data-return');                
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/returnHistory/detailHistory/"+purchaseReturn+"/"+dataReturn,
                    success : function(response){
                        $("#displayInfo").html(response);
                    }
                });
        });
        $(".BTN-APPROVE").on('click', function (e) {
            e.preventDefault();
            let el = $(this),
                purchaseReturn = el.attr('data-purchase'),
                dataReturn = el.attr('data-return');                
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/returnHistory/approveTransaksi/"+purchaseReturn+"/"+dataReturn,
                    success : function(response){
                        window.location.reload();
                    }
                });
        });
    });
</script>