<?php
    $arrayRole = array(
        1=>'Admin',
        2=>'Kasir',
        3=>'Administrator',
        4=>'sales'
    );
    $arrayLevel = array(
        1=>'Super User',
        2=>'Admin SPV',
        3=>'Admin Staff',
    );
?>
<div class="row mb-2">
    <div class="col-12">
        <table class="table table-sm table-hover table-valign-middle">
            <thead>
                <tr>
                    <th>User Area</th>
                    <th>User Hak Akses</th>
                    <th>Level Admin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select class="form-control form-control-sm " name="changeLoc" id="changeLoc">
                            <option value="{{$dbUserArea->idm_site}}" readonly>{{$dbUserArea->site_name}}</option>
                            <option disabled>---</option>
                            @foreach($mSite as $ms)
                                @if($ms->site_name <> $dbUserArea->site_name)
                                    <option value="{{$ms->idm_site}}">{{$ms->site_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="form-control form-control-sm " name="changeRole" id="changeRole">
                            <option value="{{$dbUserAuth->hakakses}}" readonly>{{$arrayRole[$dbUserAuth->hakakses]}}</option>
                            @foreach($mGroup as $mg)
                                @if($mg->group_code <> $dbUserAuth->hakakses)
                                <option value="{{$mg->group_code}}">{{$mg->group_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        @if($dbUserAuth->hakakses == '1')
                            <select class="form-control form-control-sm " name="changeLevel" id="changeLevel">
                                <option value="{{$dbUserRole->role_code}}" readonly>{{$arrayLevel[$dbUserRole->role_code]}}</option>
                                @foreach($mGAdmin as $mga)
                                    @if($mga->group_code <> $dbUserRole->role_code)
                                    <option value="{{$mga->group_code}}">{{$mga->group_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="changeLevel" id="changeLevel" value="0">
                            <span class="float-right text-danger font-weight-bold">Bukan user admin !</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <button class="btn btn-sm btn-success btn-simpan " data-id="{{$id}}">Simpan</button>    
                        <button class="btn btn-sm btn-danger btn-delete " data-id="{{$id}}">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('.btn-delete').on('click', function () {
        var element = $(this);
        var  idparam = element.attr("data-id");
        $.ajax({
            type:'get',
            url:"{{route('Personalia')}}/delHakAkses/"+idparam,
            success:function(response){
                alertify.success('Delete success, close this modal');
            }
        });
    });
    
    $('.btn-simpan').on('click', function () {
        var element = $(this);
        let  idparam = element.attr("data-id"),
            changeLoc = $("#changeLoc").val(),
            changeRole = $("#changeRole").val(),
            changeLevel = $("#changeLevel").val(),
            keyWord = "0";
        $.ajax({
            type:'post',
            data: {id:idparam,changeLoc:changeLoc,changeRole:changeRole,changeLevel:changeLevel},
            url:"{{route('Personalia')}}/changeHakAkses",
            success:function(response){
                alertify.success('Update Successfully');
                searchData(keyWord);
                $("#loadDataHakAkses").load("{{route('Personalia')}}/loadDataHakAkses",{id:idparam});
            }
        });
    });
    
    function searchData(keyWord){        
        $.ajax({
            type : 'get',
            url : "{{route('Personalia')}}/dataTablePersonalia/searchData/"+keyWord,
            success : function(response){
                $(".DIV-SPIN").fadeOut();
                $("#divListPersonalia").html(response);
            }
        });
    }
</script>