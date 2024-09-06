@php
    $no = '1';
@endphp
<div class="row">
    <div class="col-12">
        <table class="table table-striped table-valign-middle" id="tableModel">
            <thead>
                <tr>
                    <th></th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Brand</th>
                    <th>Kategori</th>
                    <th>Spesifikasi</th>
                    <th><i class="fa-solid fa-bars"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tableModel as $tm)
                    <tr>
                        <td class="text-center">
                            @if($tm->model_file_name=="")
                                <img src="{{asset('public/images/boxed-bg.jpg')}}" alt="Product Kosong" class="img-circle img-size-32 mr-2">
                            @else
                                <img src="{{asset('public/images/Upload/Model')}}/{{$tm->model_file_name}}" alt="Product 1" class="img-size-64 mr-2">
                            @endif
                        </td>
                        <td>{{$tm->model_code}}</td>
                        <td>{{$tm->model_name}}</td>
                        <td>{{$tm->manufacture_note}}</td>
                        <td>{{$tm->category_note}}</td>
                        <td>{{$tm->model_note}}</td>
                        <td class="text-right">
                            <div class="btn-group">
                                <button type="button btn-sm" class="btn btn-default" data-toggle="dropdown">
                                    <i class="fa-solid fa-bars"></i>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('M_Model')}}/arrayModel/editMenu/{{$tm->idm_asset_model}}">Edit</a>                                    
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
    $(function () {
        $('#tableModel').DataTable({
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