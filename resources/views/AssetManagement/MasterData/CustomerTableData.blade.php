@php
    $no = 1;
    $Status = array(
        0=>"Non Aktif",
        1=>"Aktif",
    );
@endphp

<table class="table table-sm table-valign-middle table-hover">
    <thead class="text-center bg-gradient-purple">
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Alamat</th>
            <th>PIC/Telefone</th>
            <th>Status</th>
            <th><i class="fa-solid fa-bars"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($customer as $c)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$c->customer_store}}</td>
                <td>{{$c->address}}</td>
                <td>{{$c->pic}} / <a href="https://wa.me/{{$c->phone_number}}?text=Hello,%20silahkan%20cek%20promo%20kami%20" target="_blank" rel="noopener noreferrer" class="text-success font-weight-bold"><i class="fa-brands fa-whatsapp"></i> {{$c->phone_number}}</a></td>
                <td>{{$Status[$c->customer_status]}}</td>
                <td class="text-right">
                    <div class="btn-group btn-sm">
                        <button type="button" class="btn btn-default" data-toggle="dropdown">
                            <i class="fa-solid fa-bars"></i>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Customers')}}/TableDataCustomer/EditTable/{{$c->idm_customer}}"><i class="fa-solid fa-pencil"></i> Edit Customer</a>                                    
                            <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Customers')}}/TableDataCustomer/EditTable/{{$c->idm_customer}}"><i class="fa-solid fa-file-lines"></i> Detail Customer</a>                                    
                            <a class="dropdown-item SUPP-DELETE" data-id="{{$c->idm_customer}}" href="#"><i class="fa-solid fa-trash-can"></i> Delete Permanently</a>
                        </div>
                    </div>
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