<?php
    $arrStatus = array(
        0=>"Dibatalkan",
        1=>"Diperiksa",
        2=>"Disetujui",
    );
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body">
            <table class="table table-sm table-valign-middle table-hover">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Sumber Dana</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tbReumbers as $tr)
                        <tr>
                            <td>{{$tr->reumbers_no}}</td>
                            <td>{{date("d-M-Y", strtotime($tr->reumbers_date))}}</td>                            
                            <td>{{$tr->from_akun}} @ {{number_format($tr->nominal_dana,'0',',','.')}}</td>
                            <td>{{$tr->description}}</td>
                            <td>{{$arrStatus[$tr->status]}}</td>
                            <td>{{number_format($tr->nominal,'0',',','.')}}</td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm"><i class="fa-solid fa-magnifying-glass"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>