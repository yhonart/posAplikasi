@if($countPoint >= '1')
    <div class="row">
        <div class="col-md-12">
            <h6 class="font-weight-bold text-muted">Riwayat Pengembalian/Retur Barang</h6>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <input type="text" name="point" id="point" class="form-control form-control-sm  text-success font-weight-bold" value="{{number_format($disPoint->NumRet,'0',',','.')}}" readonly>
        </div>
        <div class="col-md-8">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary BTN-HARGA font-weight-bold" data-supplier = "{{$suppID}}">Gunakan Potongan Harga</button>
                <button type="button" class="btn btn-outline-primary BTN-BARANG font-weight-bold" data-supplier = "{{$suppID}}">Gunakan Penggantian Barang</button>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm table-hover table-valign-middle">
                <thead>
                    <tr>
                        <th>No.Pembelian</th>
                        <th>Produk</th>
                        <th>Qty.Pembelian</th>
                        <th>Qty.Retur</th>
                        <th>Hrg.Satuan</th>
                        <th>Jml.Retur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itemReturn as $iR)
                        <tr>
                            <td>{{$iR->purchase_number}}</td>
                            <td>{{$iR->product_name}}</td>
                            <td><span class="font-weight-bold text-info">{{$iR->received}}</span></td>
                            <td><span class="font-weight-bold text-indigo">{{$iR->return}} {{$iR->unit}}</span></td>
                            <td class="text-right">{{number_format($iR->unit_price,'0',',','.')}}</td>
                            <td class="text-right">{{number_format($iR->total_price,'0',',','.')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(".BTN-HARGA").on('click', function (e) {
                e.preventDefault();
                $(".LOAD-SPINNER").fadeIn();
                let supplierID = $(this).attr('data-supplier');
                alertify.confirm("Anda akan menggunakan potongan harga dari harga retur sebelumnya ?",
                function(){
                    $.ajax({
                        type : 'get',
                        url : "{{route('Purchasing')}}/potonganHarga/"+supplierID,
                        success : function(response){
                            $(".LOAD-SPINNER").fadeOut();
                        }
                    });
                },
                function(){
                    alertify.error('Cancel');
                    $(".LOAD-SPINNER").fadeOut();
                });
            });
            $(".BTN-BARANG").on('click', function (e) {
                e.preventDefault();
                $(".LOAD-SPINNER").fadeIn();
                let supplierID = $(this).attr('data-supplier');
                alertify.confirm("Item yang di retur sebelumnya akan di ganti dengan item baru.",
                function(){
                    $.ajax({
                        type : 'get',
                        url : "{{route('Purchasing')}}/penggantianBarang/"+supplierID,
                        success : function(response){
                            $(".LOAD-SPINNER").fadeOut();
                        }
                    });
                },
                function(){
                    alertify.error('Cancel');
                    $(".LOAD-SPINNER").fadeOut();
                });
            });
        });
    </script>
@endif