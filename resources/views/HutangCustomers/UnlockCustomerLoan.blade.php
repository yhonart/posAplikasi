<table class="table table-valign-middle table-sm">
    <thead>
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
                <td>{{number_format($cslt->kredit_limit,'0',',','.')}}</td>
                <td>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="customSwitch1">                      
                    </div>
                </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>