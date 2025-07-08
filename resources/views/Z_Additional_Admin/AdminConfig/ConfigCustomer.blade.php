<div class="card text-xs card-purple">
    <div class="card-header">
        <h3 class="card-title">Konfigurasi Customer/Pelanggan</h3>
    </div>
    <div class="card-body">        
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm table-hover table-valign-middle">
                    <thead>
                        <tr>
                            <th>Cus.Code</th>
                            <th>Cus.Nama</th>
                            <th>Alamat</th>
                            <th>Type Pembayaran</th>
                            <th>Credit Limit</th>
                            <th class="text-right">Pengaturan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dbCustomer as $dbCus)
                            <tr>
                                <td>{{$dbCus->customer_code}}</td>
                                <td>{{$dbCus->customer_store}}</td>
                                <td>{{$dbCus->address}}</td>
                                <td>{{$dbCus->payment_type}}</td>
                                <td>{{$dbCus->kredit_limit}}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary font-weight-bold ATUR-PENGIRIMAN BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('sales')}}/configCustomer/aturPengiriman/{{$dbCus->idm_customer}}">Pengiriman</button>
                                        <button type="button" class="btn btn-sm btn-primary font-weight-bold ATUR-PEMBAYARAN BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('sales')}}/configCustomer/aturPembayaran/{{$dbCus->idm_customer}}">Pembayaran</button>
                                        <button type="button" class="btn btn-sm btn-primary font-weight-bold ATUR-PEMBAYARAN BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('sales')}}/configCustomer/aturPenjualan/{{$dbCus->customer_code}}">Penjualan</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>