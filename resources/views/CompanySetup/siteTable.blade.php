<div class="row">
    <div class="col-12">
        <table class="table table-sm table-valign-middle table-borderless">
            <tbody>
                <tr>
                    <td class="font-weight-bold"><i class="fa-solid fa-building"></i> {{$tableCompany->company_name}}</td>
                    <td>
                        @foreach($tableSite as $ts)
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <strong><i class="fas fa-map-marker-alt mr-1"></i> {{$ts->site_code}} | {{$ts->site_name}}</strong>                                
                            </div>
                            <div class="col-12 col-md-5">
                                <span class="text-muted">{{$ts->site_address}}</span>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-default rounded rounded-circle btn-sm" id="btnDelete" data-id="{{$ts->idm_site}}"><i class="fa-solid fa-trash text-danger"></i></button>
                                <button type="button" class="btn btn-default rounded rounded-circle btn-sm" id="EditData" data-id="{{$ts->idm_site}}"><i class="fa-solid fa-pencil text-info"></i></button>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });   
        $('#btnDelete').on('click',function (){
            let el = $(this);
            let id = el.attr("data-id");
            let loadSpinner = $(".LOAD-SPINNER"),
                routeIndex = "{{route('CompanySetup')}}",
                tableData = "warehouseTable",
                displayData = $("#displayWHTable");

            $.ajax({
                type:'get',
                url:routeIndex + "/warehouseTable/deleteData/" + id, 
                success : function(response){
                    global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                    global_style.show_swal("info","Data berhasil di hapus");
                }           
            });            
        });
    })
</script>