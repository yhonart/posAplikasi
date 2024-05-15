@php
    $no = 1;
@endphp
<table class="table table-sm table-valign-middle table-hover">
    <thead class="text-center bg-purple">
        <tr>
            <th>No</th>
            <th>Nama Toko</th>
            <th>Alamat</th>
            <th>No. Telefone</th>
            <th>Status</th>
            <th><i class="fa-solid fa-bars"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($supplier as $supp)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$supp->store_name}}</td>
                <td>{{$supp->city}}, {{$supp->address}}</td>
                <td>{{$supp->phone_number}}</td>
                <td>
                    <?php
                        if ($supp->supplier_status == "Aktif") {
                            $badge = "badge-success";
                        }
                        else{
                            $badge = "badge-danger";
                        }
                    ?>                   
                    <span class="right badge {{$badge}} p-2">{{$supp->supplier_status}}</span>
                </td>
                <td class="text-right">
                    <div class="btn-group btn-sm">
                        <button type="button" class="btn btn-default" data-toggle="dropdown">
                            <i class="fa-solid fa-bars"></i>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Supplier')}}/tableSupplier/EditSupplier/{{$supp->idm_supplier}}"><i class="fa-solid fa-pencil"></i> Edit Supplier</a>                                    
                            <a class="dropdown-item SUPP-DELETE" data-id="{{$supp->idm_supplier}}" href="#"><i class="fa-solid fa-trash-can"></i> Delete Permanently</a>
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
            routeIndex = "{{route('Supplier')}}",
            tableData = "tableSupplier",
            displayData = $("#displayTableSupplier");

        $('.SUPP-DELETE').on('click', function () {
            let el = $(this);
            let dataID = el.attr('data-id');
            $.ajax({
                url: routeIndex + "/tableSupplier/DeleteSupplier/" + dataID,
                type: 'GET',
                success: function (data) {   
                    global_style.load_table(loadSpinner,routeIndex,tableData,displayData);                        
                },                
            });
        });
    })
</script>