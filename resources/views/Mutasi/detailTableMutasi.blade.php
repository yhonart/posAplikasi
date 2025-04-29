<?php
    $stockAkhir = '0';
?>
<div class="row">
    <div class="col-12">
        <div class="card card-body">
            <div class="row mb-2">
                <div class="col-md-12">
                    <dl class="row">
                        <dt class="col-md-4">No. Dokumen</dt>
                        <dd class="col-md-4">: {{$idParam}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-md-4">Tgl. Transaksi</dt>
                        <dd class="col-md-4">: {{$docMutasi->date_moving}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-md-4">Dari - Tujuan</dt>
                        <dd class="col-md-4">: <b>{{$asalBarang->site_name}}</b> <span class=" badge badge-dark"><i class="fa-solid fa-route"></i> to</span>  <b>{{$tujuanBarang->site_name}}</b></dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-md-4">Keterangan</dt>
                        <dd class="col-md-4">: {{$docMutasi->notes}}</dd>
                    </dl>
                </div>
            </div>
            <hr>
            <table class="table table-sm table-valign-middle table-hover text-xs" id="tableDetailItemMutasi">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Stok Awal <br> <small>Tujuan Barang</small></th>
                        <th>Jml. Mutasi</th>
                        <th>Stok Akhir <br> <small>Tujuan Barang</small></th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listMutasi as $lm)
                        <tr>
                            <td>{{$lm->product_name}}</td>
                            <td>{{$lm->product_satuan}}</td>
                            <td>{{$lm->last_stock}}</td>
                            <td>{{$lm->stock_taken}}</td>
                            <td>
                                <?php
                                    $stockAkhir = $lm->last_stock - $lm->stock_taken;
                                    echo $stockAkhir;
                                ?>
                            </td>
                            <td>{{$lm->notes}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        let idparam = "{{$idParam}}";
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/formEntryMutasi/editDocMutasi/" + idparam,
            success : function(response){     
                $("#divDisplayDokumen").html(response);
            }
        });
    })
    $(function(){        
        $("#tableDetailItemMutasi").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.btnTerimaBarang').on('click', function () {
            var  paramID = "{{$idParam}}";
            $.ajax({
                type:'get',
                url:"{{route('mutasi')}}/tableDataMutasi/pickup/"+paramID,
                dataType: 'html',
                success:function(response){
                    window.location.reload();
                }
            });
        });
    });
</script>