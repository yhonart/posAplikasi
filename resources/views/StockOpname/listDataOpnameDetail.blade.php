<?php
    $noDetail = '1';
?>
<button class="btn btn-primary btn-sm elevation-1" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Detail Keterangan
</button>
<button class="btn btn-warning btn-sm elevation-1" type="button" id="btn-reload">
    <i class="fa-solid fa-circle-xmark"></i> Close
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


<div class="row mt-2">
    <div class="col-12">
        <div class="card card-body p-0 table-responsive" style="height: 300px;">
            <table class="table table-sm table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
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
                            <td>{{$listPrd->last_stock}}</td>
                            <td>{{$listPrd->input_qty}}</td>
                            <td>{{$listPrd->selisih}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-info font-weight-bold">
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td>{{$sumDetailOpname->lastStock}}</td>
                        <td>{{$sumDetailOpname->inputStock}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $('#btn-reload').on('click', function () {
        window.location.reload();
        //$("#cardDetail").fadeOut('slow');
    });
</script>