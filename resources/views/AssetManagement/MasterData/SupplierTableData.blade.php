@php
    $no = 1;
@endphp
<table class="table table-valign-middle table-hover table-sm" id="tableSupplier">    
    <tbody>
        @foreach($supplier as $supp)
            <tr>
                <td>
                    <a href="#" class="DETAIL-SUP text-navy" data-index="{{$supp->idm_supplier}}">
                        {{$supp->store_name}}
                    </a>
                </td>
                <td>
                    <a class="SUPP-DELETE btn  btn-outline-danger btn-sm float-right" data-id="{{$supp->idm_supplier}}" href="#"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function () {
        $('#tableSupplier').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
    });
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
        $('.DETAIL-SUP').on('click', function () {
            let el = $(this);
            let dataID = el.attr('data-index');
            $.ajax({
                url: "{{route('Supplier')}}/tableSupplier/EditSupplier/" + dataID,
                type: 'GET',
                success: function (response) {
                    $("#displaySupplier").html(response);
                },                
            });
        });
    })
</script>