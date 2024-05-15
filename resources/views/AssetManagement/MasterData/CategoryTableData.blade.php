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
                @foreach($tableCategory as $tc)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$tc->category_code}}</td>
                        <td>{{$tc->category_name}}</td>
                        <td class="text-right">
                            <div class="btn-group">
                                <button type="button btn-sm" class="btn btn-default" data-toggle="dropdown">
                                    <i class="fa-solid fa-bars"></i>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('M_Category')}}/arrayCategory/editMenu/{{$tc->idm_asset_category}}">Edit</a>
                                    <a class="dropdown-item ITEM-ACTION" href="#" idCat="{{$tc->idm_asset_category}}">Delete (Permanently)</a>                                    
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
            let id = el.attr("idCat");
            let loadSpinner = $(".LOAD-SPINNER"),
                routeIndex = "{{route('M_Category')}}",
                tableData = "arrayCategory",
                displayData = $("#displayTableCategory");

            $.ajax({
                type:'get',
                url:routeIndex + "/arrayCategory/DelPermanently/" + id, 
                success : function(response){
                    global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                }           
            });            
        })
    })
</script>