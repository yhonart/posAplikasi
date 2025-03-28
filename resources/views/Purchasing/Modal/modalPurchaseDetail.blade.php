<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Penerimaan Barang</h3>
            </div>
            <div class="card-body text-xs">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">Nomor</td>
                            <td>{{$modalDetailPO->purchase_number}}</td>
                            <td class="font-weight-bold">Tgl. Penerimaan</td>
                            <td>{{$modalDetailPO->purchase_date}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Supplier</td>
                            <td>{{$modalDetailPO->store_name}}</td>
                            <td class="font-weight-bold">Type Pembayaran</td>
                            <td>{{$modalDetailPO->tempo}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">No. Faktur</td>
                            <td>{{$modalDetailPO->faktur_number}}</td>
                            <td class="font-weight-bold">Tgl. Faktur</td>
                            <td>{{$modalDetailPO->faktur_date}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mt-2">
                    <div class="col-md-12">
                        @include('Purchasing.Modal.ModalPurchasingDetailBarang')                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>