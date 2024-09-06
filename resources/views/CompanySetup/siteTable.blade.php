<div class="row">
    <div class="col-12">
        <table class="table table-sm table-valign-middle table-borderless">
            <tbody>
                <tr>
                    <td class="font-weight-bold"><i class="fa-solid fa-building"></i> {{$tableCompany->company_name}}</td>
                    <td>
                        @foreach($tableSite as $ts)
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <strong><i class="fas fa-map-marker-alt mr-1"></i> {{$ts->site_code}} | {{$ts->site_name}}</strong>
                                <div class="form-group row collapse mt-2" id="collapseDataSite{{$ts->idm_site}}">
                                    <div class="col-12 col-md-3">
                                        <input type="text" name="siteCode" value="{{$ts->site_code}}" class="form-control form-control-sm" onchange="saveDataSite(this,'m_site','site_code','{{$ts->idm_site}}','idm_site')">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" name="namaLokasi" value="{{$ts->site_name}}" class="form-control form-control-sm" onchange="saveDataSite(this,'m_site','site_name','{{$ts->idm_site}}','idm_site')">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" name="alamat" value="{{$ts->site_address}}" class="form-control form-control-sm" onchange="saveDataSite(this,'m_site','site_address','{{$ts->idm_site}}','idm_site')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <span class="text-muted">{{$ts->site_address}}</span>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-default rounded rounded-circle btn-sm BTN-DELETE" data-id="{{$ts->idm_site}}"><i class="fa-solid fa-trash text-danger"></i></button>
                                <button type="button" class="btn btn-default rounded rounded-circle btn-sm" data-toggle="collapse" data-target="#collapseDataSite{{$ts->idm_site}}" aria-expanded="false" aria-controls="collapseDataSite{{$ts->idm_site}}"><i class="fa-solid fa-pencil text-info"></i></button>
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
        $('.BTN-DELETE').on('click',function (){
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
    function saveDataSite(editTableObj,tableName,column,id,tableID) {
        $.ajax({
            url: "{{route('CompanySetup')}}/warehouseTable/updateDataSite",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.value+'&id='+id+'&tableID='+tableID,
            success: function(data){
                 Toast.fire({
                    title: 'Success!'
                  })
            }
        });
    } 
</script>