<div class="card card-body">
    <table class="table table-sm">
        <thead class="bg-gray-dark">
            <tr>
                <th>Purchase Number</th>
                <th>Tanggal</th>
                <th>Point Belanja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historyReturn as $hisReturn)
                <tr>
                    <td>{{$hisReturn->purchase_number}}</td>
                    <td>{{date_format("d-M-Y", strtotime($hisReturn->created_at))}}</td>
                    <td>{{$hisReturn->price}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>