@if($dataTrx == '0')
    <div class="card card-body">
        <span>Tidak ada jenis transaksi yang dipilih!</span>
    </div>
@else
    <div class="card card-body table-responsive">
        <table class="table table-sm table-valign-middle">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Suplier</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataTrx as $dtr)
                    <tr>
                        <td>{{$dtr->purchase_number}}</td>
                        <td>{{$dtr->store_name}}</td>
                        <td>{{$dtr->purchase_date}}</td>
                        <td>{{number_format($dtr->sub_total,'0',',','.')}}</td>
                        <td></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info "><i class="fa-solid fa-pencil"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif