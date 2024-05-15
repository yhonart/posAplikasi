@php
    $no = '1';
@endphp
<div class="row">
    <div class="col-12">
        <table class="table table-hover table-valign-middle table-sm">
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
                        <td>{{$tm->manufacture_code}}</td>
                        <td>{{$tm->manufacture_name}}</td>
                        <td class="text-right">
                            <div class="btn-group btn-sm">
                                <button type="button" class="btn btn-default" data-toggle="dropdown">
                                    <i class="fa-solid fa-bars"></i>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('M_Manufacture')}}/arrayManufacture/editMenu/{{$tm->idm_asset_manufacture}}">Edit</a>
                                    <a class="dropdown-item ITEM-ACTION" href="#" idMF="{{$tm->idm_asset_manufacture}}">Delete (Permanently)</a>                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>    
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