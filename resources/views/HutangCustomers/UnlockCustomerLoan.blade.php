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
                <td class="text-right">
                    {{number_format($cslt->kredit_limit,'0',',','.')}}
                    <button type="button" id="editLimit" class="btn btn-sm btn-default border-0"><i class="fa-solid fa-file-pen"></i></button>
                </td>
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