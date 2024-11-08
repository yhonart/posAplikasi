<div class="card">
    <div class="card-header">
        <h3 class="card-title">Transaksi Kas</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm table-valig-middle table-hover">
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
                </table>
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
                            <td>{{$d->file_name}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info"><i class="fa-solid fa-pencil"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </div>
        </div>
    </div>
</div>