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
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input unlock-trx" id="customSwitch{{$cslt->idm_customer}}"> 
                      <label class="custom-control-label" for="customSwitch{{$cslt->idm_customer}}">Lock/Unlock</label>                     
                    </div>
                </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>