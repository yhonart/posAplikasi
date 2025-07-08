<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Pengaturan Penjualan Pelanggan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-warning">Tambah Order</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-valign-middle hover">
                            <thead>
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Qty.Order</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customerOrder as $cor)
                                    <tr>
                                        <td>{{$cor->product_code}}</td>
                                        <td>{{$cor->product_name}}</td>
                                        <td>{{$cor->qty_order}}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-xmark"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-warning font-weight-bold" data-dismiss="modal" aria-label="Close">Tutup</button>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</div>