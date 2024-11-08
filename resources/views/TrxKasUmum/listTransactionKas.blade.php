<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Transaksi Kas</h3>
    </div>
    <div class="card-body table-responsive">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm table-valig-middle table-hover" id="tableTrxKas">
                    <thead>
                        <tr>
                            <th>No. Trx</th>
                            <th>Tgl.</th>
                            <th>Deskripsi</th>
                            <th>Sub-Kategori</th>
                            <th>Keterangan</th>
                            <th>User</th>
                            <th>Debit</th>
                            <th>Lampiran</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($displayByDate as $d)
                            <tr>
                                <td>
                                    <?php
                                        $dateTk = date("dmy", strtotime($d->kas_date));
                                        $idTk = $d->idtr_kas;
                                        $noTrx = "KAS" . $dateTk . "-" . sprintf("%07d", $idTk);
                                    ?>
                                    {{$noTrx}}
                                </td>
                                <td>{{date("d-M-Y", strtotime($d->kas_date));}}</td>
                                <td>{{$d->cat_name}}</td>
                                <td>{{$d->subcat_name}}</td>
                                <td>{{$d->description}}</td>
                                <td>{{$d->kas_persName}}</td>
                                <td>{{number_format($d->nominal,'0',',','.')}}</td>
                                <td>
                                    @if($d->file_name <> '')
                                        <a href="{{asset('public/images/Upload/TrxKas')}}/{{$d->file_name}}" target="_blank" rel="noopener noreferrer" title="{{$d->file_name}}">Lampiran</a>                                    
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info EDIT-KAS" data-id="{{$d->idtr_kas}}"><i class="fa-solid fa-pencil"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#tableTrxKas").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');        
    });
    $(document).ready(function(){
        $(".dataTable").on('click','.EDIT-KAS', function () {
            let el = $(this);
            let id = el.attr("data-id");
            $.ajax({
                type : 'get',
                url : "{{route('trxKasUmum')}}/modalEditKas/"+id,
                success : function(response){
                    $("#actionDisplay").html(response);
                }
            });
        })
    })
</script>