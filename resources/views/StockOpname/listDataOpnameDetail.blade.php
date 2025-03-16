<?php
    $noDetail = '1';
?>
<hr>
<div class="row mt-2">
    <div class="col-12">
        <div class="card card-body table-responsive" style="height: 600px;">
            <div class="row mb-2">
                <div class="col-md-12">
                <button class="btn btn-sm bg-light border-0 font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa-regular fa-file"></i> <span class="text-info">Dokumen Transaksi</span>
                </button>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <dl class="row mb-1">
                                    <dt class="col-4">No Stock Opname</dt>
                                    <dd class="col-4">{{$detailOpname->number_so}}</dd>
                                </dl>
                                <dl class="row mb-1">
                                    <dt class="col-4">Tanggal</dt>
                                    <dd class="col-4">{{$detailOpname->date_so}}</dd>
                                </dl>
                                <dl class="row mb-1">
                                    <dt class="col-4">Lokasi Barang</dt>
                                    <dd class="col-4">{{$detailOpname->site_name}}</dd>
                                </dl>
                                <dl class="row mb-1">
                                    <dt class="col-4">Keterangan</dt>
                                    <dd class="col-4">{{$detailOpname->description}}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm table-valign-middle table-hover " id="tableDetailStokOpname">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Qty. Opname</th>
                                <th>Stok Awal</th>
                                <th>Stok Akhir</th>
                                <th>Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailProductLs as $listPrd)
                                <tr>
                                    <td>{{$noDetail++}}</td>
                                    <td>{{$listPrd->product_name}}</td>
                                    <td>{{$listPrd->product_satuan}}</td>
                                    <td>{{$listPrd->input_qty}}</td>
                                    <td>{{$listPrd->last_stock}}</td>
                                    <td>{{$listPrd->input_qty}}</td>
                                    <td>{{$listPrd->selisih}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light font-weight-bold">
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td>{{$sumDetailOpname->lastStock}}</td>
                                <td>{{$sumDetailOpname->inputStock}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btn-reload').on('click', function () {
        window.location.reload();
        //$("#cardDetail").fadeOut('slow');
    });
    $(function(){        
        $("#tableDetailStokOpname").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>