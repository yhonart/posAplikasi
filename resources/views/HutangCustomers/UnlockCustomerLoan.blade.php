<table class="table table-valign-middle table-sm table-bordered">
    <thead class="bg-gradient-purple font-weight-bold">
        <tr>
            <td>Kode Pelanggan</td>
            <td>Nama Pelanggan</td>
            <td>Limit Hutang</td>
            <td>Lock & Unlock</td>
        </tr>
    </thead>
    <tbody>
        @foreach($customerListTrx as $cslt)
            <tr>
                <td>{{$cslt->customer_code}}</td>
                <td>{{$cslt->customer_store}}</td>
                <td>
                    <i class="fa-solid fa-rupiah-sign float-left"></i>
                    <a href="#" class="text-info font-weight-bold float-right">
                        {{number_format($cslt->kredit_limit,'0',',','.')}} <i class="fa-solid fa-file-pen"></i>
                    </a>
                </td>
                <td>
                <div class="form-group">
                    @if($cslt->loan_lock == '0')
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input CHANGE_RESERVE" id="customSwitch{{$cslt->idm_customer}}" value="{{$cslt->idm_customer}}" checked> 
                      <label class="custom-control-label" for="customSwitch{{$cslt->idm_customer}}">Lock/Unlock</label>                     
                    </div>
                    @else
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input CHANGE_RESERVE" id="customSwitch{{$cslt->idm_customer}}"> 
                      <label class="custom-control-label" for="customSwitch{{$cslt->idm_customer}}">Lock/Unlock</label>                     
                    </div>
                    @endif
                </div>
                </td>
            </tr>            
        @endforeach
    </tbody>
</table>

<script>
    $(document).on('change','.CHANGE_RESERVE :checkbox',function(e){
        e.preventDefault();
        if ($(this).is(':checked')) {
            var id_asset = $(this).val();
            var data_reserve = {id_asset:id_asset,reservable:1};

            alert(data_reserve);
        } else {
            var id_asset = $(this).val();
            var data_reserve = {id_asset:id_asset,reservable:0};

            alert(data_reserve);
        }
    });
</script>