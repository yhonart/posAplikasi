<div class="card card-indigo">
    <div class="card-header">
        <h3 class="card-title">Gunakan Voucher</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h6 class="font-weight-bold text-muted">Riwayat Pengembalian/Retur Barang</h6>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <input type="text" name="point" id="point" class="form-control form-control-sm  text-success font-weight-bold" value="{{number_format($disPoint->NumRet,'0',',','.')}}" readonly>
            </div>
            <div class="col-md-9">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary BTN-HARGA font-weight-bold" data-supplier = "{{$supID}}">Gunakan Semua Potongan Harga</button>
                    <button type="button" class="btn btn-outline-primary BTN-BARANG font-weight-bold" data-supplier = "{{$supID}}">Gunakan Penggantian Semua Barang</button>
                    <button type="button" class="btn btn-outline-primary BTN-CUSTOME font-weight-bold" data-toggle="collapse" href="#collapseInvoice" role="button" aria-expanded="false" aria-controls="collapseInvoice">Gunakan Beberapa Nomor Transaksi</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="collapse" id="collapseInvoice">
                    <div class="card card-body">
                        <table class="table table-sm table-valign-middle table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Purchase</th>
                                    <th class="text-right">Nominal</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($itemByNumber as $ibn)
                                    <tr>
                                        <td>{{$ibn->purchase_number}}</td>
                                        <td class="text-right font-weight-bold">{{number_format($ibn->NumRet,'0',',','.')}}</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gunakanRetur" value="{{$ibn->purchase_number}}">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="button" class="btn btn-sm" id="btnSimpanPilih"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm table-hover table-valign-middle" id="tableItemRetur">
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
    </div>
    <div class="card-footer">
        <span>Pilih cara penggunaan dengan benar</span>
    </div>
</div>

<script>
    $(function(){        
        $("#tableItemRetur").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
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
            }).set({title:"Notif Penggunaan Harga Barang."});
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
            }).set({title:"Notif Penukaran Barang."});;
        });
    });
</script>