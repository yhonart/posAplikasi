<?php
    $stockAkhir = '0';
?>
<div class="row">
    <div class="col-12">
        <div class="card card-body border border-info">
            <div class="row mb-2">
                <div class="col-12 col-md-6">
                    <button class="btn btn-default mb-2 border-0 font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-file-lines"></i> <span class="text-info">Dokumen Mutasi</span>
                    </button>
                    <div class="collapse" id="collapseExample">
                        <div id="divDisplayDokumen"></div>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-valign-middle table-hover table-bordered" id="tableDetailItemMutasi">
                <thead class="bg-gray">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Asal Barang</th>
                        <th>Tujuan Barang</th>
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
                            <td>{{$asalBarang->site_name}}</td>
                            <td>{{$tujuanBarang->site_name}}</td>
                            <td>{{$lm->last_stock}}</td>
                            <td>{{$lm->stock_taken}}</td>
                            <td>
                                <?php
                                    $stockAkhir = $lm->last_stock + $lm->stock_taken;
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