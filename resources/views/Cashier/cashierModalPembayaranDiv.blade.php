@foreach($tableMethod as $tbMethod)
<tr>
    <td class="text-right font-weight-bold"></td>
    <td>
        <select name="editMetodePembayaran" id="editMetodePembayaran" class="form-control">
            <option value="{{$tbMethod->mID}}">{{$tbMethod->mName}}</option>
            @foreach($paymentMethod2 as $pM2)
                <option value="{{$pM2->idm_payment_method}}">
                    {{$pM2->method_name}}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" class="form-control type-account editVal" name="editNominal" id="editNominal" value="{{$tbMethod->nominal}}" autocomplete="off" onchange="saveMethod(this,'tr_payment_method','nominal','{{$tbMethod->idtr_method}}','idtr_method')">
    </td>
    <td>
        <!--<button type="button" class="btn btn-danger" id="addPaymentMethod"><i class="fa-solid fa-xmark"></i></button>-->
    </td>
</tr>
@endforeach
<script>
    $(".editVal").mask('000.000.000', {reverse: true});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function saveMethod(editTableObj,tableName,column,id,tableID) {
        $.ajax({
            url: "{{route('home')}}/GlobalLiveEditTable",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.value+'&id='+id+'&tableId='+tableID,
            success: function(data){
                alertify.warning('Success');
            }
        });
    } 
</script>