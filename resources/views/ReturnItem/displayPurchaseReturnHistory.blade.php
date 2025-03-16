
<?php
$arrStatus = array(
    0=>"Batal",
    1=>"Dalam Proses",
    2=>"Di Periksa",
    3=>"Di Setujui",
    4=>"Sudah Digunakan"
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
                        <td>{{$hisReturn->store_name}}</td>
                        <td>{{$hisReturn->purchase_number}}</td>
                        <td class="text-right">{{number_format($hisReturn->price,'0',',','.')}}</td>
                        <td class="text-right">
                            <span class="bg-light border border-success pl-2 pr-2 pt-1 pb-1 rounded-pill">{{$arrStatus[$hisReturn->status]}}</span>
                        </td>
                        <td class="text-right">
                            @if($hisReturn->status == '2')
                                <button type="button" class="btn btn-sm btn-success BTN-APPROVE font-weight-bold" data-purchase="{{$hisReturn->purchase_number}}"><i class="fa-solid fa-check"></i></button>
                            @endif
                            <button type="button" class="btn btn-sm btn-info BTN-DETAIL font-weight-bold" data-purchase="{{$hisReturn->purchase_number}}"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                purchaseReturn = el.attr('data-purchase');                
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/returnHistory/detailHistory/"+purchaseReturn,
                    success : function(response){
                        $("#displayInfo").html(response);
                    }
                });
        });
        $(".BTN-APPROVE").on('click', function (e) {
            e.preventDefault();
            let el = $(this),
                purchaseReturn = el.attr('data-purchase');                
                $.ajax({
                    type : 'get',
                    url : "{{route('returnItem')}}/returnHistory/approveTransaksi/"+purchaseReturn,
                    success : function(response){
                        window.location.reload();
                    }
                });
        });
    });
</script>