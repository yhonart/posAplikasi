@php
    $no = '1';
@endphp
<div class="row">
    <div class="col-12">
        <table class="table table-hover table-valign-middle table-sm" id="tableKategori">
            <thead class="text-center bg-gray">
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
                        <td class="font-weight-bold">CAT{{sprintf('%05d',$tc->idm_asset_category)}}</td>
                        <td>{{$tc->category_name}}</td>
                        <td class="text-right">
                            <button class="btn btn-info btn-sm  BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('M_Category')}}/arrayCategory/editMenu/{{$tc->idm_asset_category}}"><i class="fa-solid fa-pencil"></i> Edit</button>
                            <button class="btn btn-danger btn-sm  ITEM-ACTION" idCat="{{$tc->idm_asset_category}}" nameCat="{{$tc->category_name}}"><i class="fa-solid fa-trash-can"></i> Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function () {
        $('#tableKategori').DataTable({
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
        $(".dataTable").on('click','.ITEM-ACTION', function () {
            let el = $(this);
            let id = el.attr("idCat");
            let nameCat = el.attr("nameCat");
            let loadSpinner = $(".LOAD-SPINNER"),
                routeIndex = "{{route('M_Category')}}",
                tableData = "arrayCategory",
                displayData = $("#displayTableCategory");
                alertify.confirm("Apakah anda yakin ingin menghapus kategori "+nameCat+" ?.",
                function(){
                    $.ajax({
                        type:'get',
                        url:routeIndex + "/arrayCategory/DelPermanently/" + id, 
                        success : function(response){
                            global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                        }           
                    });            
                    alertify.success('Ok');
                },
                function(){
                    alertify.error('Cancel');
                });
        })
    })
</script>