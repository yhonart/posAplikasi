<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Transaksi Stock Opname</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Create By</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tableOpname as  $to)
                    <tr>
                        <td>{{$to->number_so}}</td>
                        <td>{{$to->date_so}}</td>
                        <td>{{$to->site_name}}</td>
                        <td>{{$to->status}}</td>
                        <td>{{$to->created_by}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>