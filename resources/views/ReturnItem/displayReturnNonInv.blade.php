<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Retur Non Invoice</h3>
    </div>
    <div class="card-body">
        @if($countNumberRetur == '0')
            <div class="form-group row">
                <label for="supplier" class="col-md-3"> Supplier</label>
                <div class="col-md-4">
                    <select name="supplier" id="supplier" class="form-control form-control-sm">
                        <option value="0"> ==== </option>
                        @foreach($optionSupplier as $ops)
                            <option value="{{$ops->idm_supplier}}">{{$ops->store_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <div id="transaksiReturNonInvoice"></div>
        @endif
    </div>
</div>