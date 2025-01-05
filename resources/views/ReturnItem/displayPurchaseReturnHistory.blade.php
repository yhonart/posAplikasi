<div class="card card-body">
    <table class="table table-sm">
        <thead class="bg-gray-dark">
            <tr>
                <th>Supplier</th>
                <th>Purchase Number</th>
                <th class="text-right">Point Belanja</th>
                <th class="text-right">#</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historyReturn as $hisReturn)
                <tr>
                    <td>{{$hisReturn->store_name}}</td>
                    <td>{{$hisReturn->purchase_number}}</td>
                    <td class="text-right">{{number_format($hisReturn->price,'0',',','.')}}</td>
                    <td class="text-right">
                        <button type="button" class="btn btn-sm btn-info BTN-DETAIL"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>

</script>