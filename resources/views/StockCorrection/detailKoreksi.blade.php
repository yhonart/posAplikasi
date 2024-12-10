<?php
$arayDK = array(
        "D"=>"Debit",
        "K"=>"Kredit",
        
    );
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body p-2 table-responsive">
            <div class="row mb-2">
                <div class="col-md-12">                    
                    <button class="btn btn-default btn-sm font-weight-bold border-0" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-file-lines"></i> Detail Dokumen
                    </button>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="collapse" id="collapseExample">
                    <div class="card card-body border border-info elevation-0">
                        <dl class="row">
                            <dt class="col-md-2">No Dokumen</dt>
                            <dd class="col-md-4">: {{$dokumenKoreksi->number}}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-md-2">Tgl. Dokumen</dt>
                            <dd class="col-md-4">: {{$dokumenKoreksi->dateInput}}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-md-2">Keterangan</dt>
                            <dd class="col-md-4">: {{$dokumenKoreksi->notes}}</dd>
                        </dl>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-valign-middle table-hover table-bordered" id="tableDetailKoreksi">
                        <thead class="bg-gray">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Lokasi</th>
                                <th>Satuan</th>
                                <th>D/K</th>
                                <th>Qty</th>
                                <th>Stok Awal</th>
                                <th>Stok Perbaikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailKoreksi as $dK)
                                <tr>
                                    <td>{{$dK->product_name}}</td>
                                    <td>{{$dK->site_name}}</td>
                                    <td>{{$dK->product_satuan}}</td>
                                    <td><span class="bg-info pt-1 pb-1 pl-2 pr-2 rounded-lg elevation-1 font-weight-bold">{{$dK->d_k}}</span> {{$arayDK[$dK->d_k]}}</td>
                                    <td>{{$dK->input_qty}}</td>
                                    <td>{{$dK->stock}}</td>
                                    <td>{{$dK->qty}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#closeDetail').on('click', function (e) {
        e.preventDefault();
        viewListTableKoreksi();
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
    function viewListTableKoreksi(){
        $.ajax({
            type : 'get',
            url : "{{route('koreksiBarang')}}/listDataKoreksi",
            success : function(response){
                $('#displayOnDiv').html(response);
            }
        });
    }
</script>