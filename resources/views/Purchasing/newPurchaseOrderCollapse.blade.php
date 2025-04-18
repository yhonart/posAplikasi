<form class="form" id="fromEditPembelian">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">NO. Transaksi</label>
                        <input type="text" name="noTrx" id="noTrx" class="form-control form-control-sm" value="{{$numberPurchase->purchase_number}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">Kirim Melalui</label>
                        <input type="text" name="deliveryBy" id="deliveryBy" class="form-control form-control-sm" value="{{$numberPurchase->delivery_by}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">Metode Pembayaran</label>
                        <select class="form-control form-control-sm select-2" name="methodPayment" id="methodPayment">
                            <option value="{{$numberPurchase->payment_methode}}">{{$numberPurchase->tempo}}</option>
                            <option value="1">Cash on Delivery</option>
                            <option value="2">Transfer</option>
                            <option value="3">Tempo [Custome]</option>
                            <option value="30">Net 30</option>
                            <option value="15">Net 15</option>
                            <option value="60">Net 60</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">Tgl. Faktur</label>
                        <input type="text" name="tglFaktur" id="tglFaktur" class="form-control form-control-sm datetimepicker-input" value="{{$numberPurchase->faktur_date}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group row">
                    <div class='col-12'>
                        <label class="label">Tgl. Pembelian</label>
                        <input type="text" name="tglTrx" id="tglTrx" class="form-control form-control-sm datetimepicker-input" value="{{$numberPurchase->purchase_date}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">Nomor Surat Jalan</label>
                        <input type="text" name="noSj" id="noSj" class="form-control form-control-sm" value="{{$numberPurchase->do_number}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">Tempo [Hari]</label>
                        <input type="text" name="dayKredit" id="dayKredit" class="form-control form-control-sm" placeholder="Abaikan Jika Menggunakan COD/Transfer" value="{{$numberPurchase->tempo}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" value="{{$numberPurchase->description}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">Supplier</label>
                        <select class="form-control form-control-sm select-2" name="supplier" id="supplier">
                            <option value="{{$numberPurchase->supplier_id}}">{{$numberPurchase->store_name}}</option>
                            @foreach($supplier as $s)
                                @if($s->idm_supplier <> $numberPurchase->supplier_id)
                                    <option value="{{$s->idm_supplier}}">{{$s->store_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">Tgl. Pengiriman</label>
                        <input type="text" name="dateDelivery" id="dateDelivery" class="form-control form-control-sm datetimepicker-input" value="{{$numberPurchase->delivery_date}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label class="label">No. Faktur</label>
                        <input type="text" name="noFaktur" id="noFaktur" class="form-control form-control-sm" value="{{$numberPurchase->faktur_number}}">
                    </div>
                </div>
                <div class="form-group row ml-2">
                    <div class="col-12">
                        <label class="label">Type PPN</label>
                    </div>
                    <div class="col-4">
                        <input type="radio" name="ppn" id="ppn" class="form-check-input mr-2" checked value="1"><label class="form-check-label">Non PPN</label>
                    </div>
                    <div class="col-4">
                        <input type="radio" name="ppn" id="ppn" class="form-check-input mr-2" value="2"><label class="form-check-label">PPN</label>
                    </div>
                    <div class="col-4">
                        <input type="radio" name="ppn" id="ppn" class="form-check-input mr-2" value="3"><label class="form-check-label">Exclude PPN</label>
                    </div>
                </div>
                <div class="form-group row ml-2">
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm" name="nomPPN" id="nomPPN">
                    </div>
                    <label class="label col-6">%</label>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-success btn-sm btn-block font-weight-bold elevation-2" id="submitPenerimaan">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>