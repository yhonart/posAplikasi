<div class="card card-body">
    <table class="table table-sm">
        <thead class="bg-gray-dark">
            <tr>
                <th>Supplier</th>
                <th>Purchase Number</th>
                <th>Point Belanja</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historyReturn as $hisReturn)
                <tr>
                    <td>{{$hisReturn->store_name}}</td>
                    <td>{{$hisReturn->purchase_number}}</td>
                    <td>{{$hisReturn->price}}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info BTN-DETAIL"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    
</script>