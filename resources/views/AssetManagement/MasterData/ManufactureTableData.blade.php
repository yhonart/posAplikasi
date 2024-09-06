@php
    $no = '1';
@endphp
<div class="row">
    <div class="col-12">
        <table class="table table-hover table-valign-middle table-sm" id="tableManufacture">
            <thead class="text-center bg-gradient-purple">
                <tr>
                    <th>No.</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tableManufacture as $tm)
                    <tr>
                        <td>{{$no++}}</td>
                        <td class="font-weight-bold">MF{{sprintf('%05d',$tm->idm_asset_manufacture)}}</td>
                        <td>{{$tm->manufacture_name}}</td>
                        <td class="text-right">
                            <a class="btn btn-flat btn-sm btn-info font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('M_Manufacture')}}/arrayManufacture/editMenu/{{$tm->idm_asset_manufacture}}"><i class="fa-solid fa-pencil"></i> Edit</a>
                            <a class="btn btn-flat btn-sm btn-danger ITEM-ACTION font-weight-bold" href="#" idMF="{{$tm->idm_asset_manufacture}}"><i class="fa-solid fa-trash-can"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>  
    $(function () {
        $('#tableManufacture').DataTable({
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
        $('.ITEM-ACTION').on('click',function (){
            let el = $(this);
            let id = el.attr("idMF");
            let loadSpinner = $(".LOAD-SPINNER"),
                routeIndex = "{{route('M_Manufacture')}}",
                tableData = "arrayManufacture",
                displayData = $("#displayTableManufacture");

            $.ajax({
                type:'get',
                url:routeIndex + "/arrayManufacture/DelPermanently/" + id, 
                success : function(response){
                    global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                }           
            });            
        })
    })
</script>