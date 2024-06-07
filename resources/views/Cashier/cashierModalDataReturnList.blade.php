<div class="row">
    <div class="col-12">
        <p class="bg-info p-2"><i class="fa-solid fa-circle-info"></i> Klik pada nomor transaksi untuk menampilkan list barang. Atau gunakan TAB pada keyboard kemudian ENTER</p>
    </div>
</div>
<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Nomor Transaksi</th>
                    <th>Nama Toko</th>
                    <th>Total Transaksi (Rp.)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listDataNumber as $ldN)
                    <tr>
                        <td>
                            <a href="#" class="text-info click-info-data font-weight-bold" data-id="{{$ldN->billing_number}}">
                                {{$ldN->billing_number}}
                            </a>
                        </td>
                        <td>{{$ldN->customer_name}}</td>
                        <td class="text-right font-weight-bold">{{number_format($ldN->t_bill,'0',',','.')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        let divViewId = $("#divDataReturn");        
        $(".click-info-data").click(function(){
            let element = $(this) ;
            let dataTrx = element.attr("data-id");
            window.open("{{route('Cashier')}}/buttonAction/dataReturn/clickListProduk/"+dataTrx, "_blank");
        }); 
    });
</script>