@php
    $no = 1;
    $Status = array(
        0=>"Non Aktif",
        1=>"Aktif",
        2=>"Non Member",
    );
@endphp
<table class="table table-sm table-valign-middle table-hover">
    <thead class="text-center bg-gradient-purple">
        <tr>
            <th>Nama Pelanggan</th>
    </thead>
    <tbody>
        @foreach($customer as $c)
            <tr>
                <td>
                    <a class="text-navy DETAIL-CUS" href="{{route('Customers')}}/TableDataCustomer/EditTable/{{$c->idm_customer}}">{{$c->customer_store}}</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });  
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('Customers')}}",
            tableData = "TableDataCustomer",
            displayData = $("#displayTableCustomers");

        $('.SUPP-DELETE').on('click', function () {
            let el = $(this);
            let dataID = el.attr('data-id');
            $.ajax({
                url: routeIndex + "/TableDataCustomer/DeleteTable/" + dataID,
                type: 'GET',
                success: function (data) {   
                    global_style.load_table(loadSpinner,routeIndex,tableData,displayData);                        
                },                
            });
        });
    })
</script>