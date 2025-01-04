<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Pembayaran</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body border-info">
                            <p class="font-weight-bold text-primary">Rincian Pembelian</p>
                            <dl class="row">
                                <dt class="col-md-4">No. Pembelian</dt>
                                <dd class="col-md-8">: {{$purchaseOrder->purchase_number}}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-md-4">Tgl. Pembelian</dt>
                                <dd class="col-md-8">: {{$purchaseOrder->delivery_date}}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-md-4">Nominal Pembelian</dt>
                                <dd class="col-md-8">: {{number_format($purchaseOrder->sub_total,'0',',','.')}}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body">
                            <p class="font-weight-bold text-primary">Rincian Pembayaran</p>
                            <dl class="row">
                                <dt class="col-md-4">No. Pembayaran</dt>
                                <dd class="col-md-8">: {{$pembayaran->nomor}}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-md-4">Tanggal Pembayaran</dt>
                                <dd class="col-md-8">: {{$pembayaran->payment_date}}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-md-4">Metode Pembayaran</dt>
                                <dd class="col-md-8">: {{$pembayaran->methode}}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-md-4">Nominal Pembayaran</dt>
                                <dd class="col-md-8">: {{number_format($pembayaran->kredit_pay,'0',',','.')}}</dd>
                            </dl>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-sm table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th class="text-right">Nominal</th>
                                                <th class="text-right">Kurang Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Kredit</td>
                                                <td>0</td>
                                                <td class="text-right">{{number_format($purchaseOrder->sub_total,'0',',','.')}}</td>
                                            </tr>
                                            @foreach($historyPm as $hp)
                                                <tr>
                                                    <td>{{$hp->payment_date}}</td>
                                                    <td class="text-right">{{number_format($hp->kredit_pay,'0',',','.')}}</td>
                                                    <td class="text-right">{{number_format($hp->selisih,'0',',','.')}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>