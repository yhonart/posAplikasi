<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Retur Non Invoice</h3>
    </div>
    <div class="card-body">
        @if($countNumberRetur == '0')
            <form id="formCreateDokRetur">
                <div class="form-group row">
                    <label for="numberDokumen" class="col-md-3">No. Dokumen</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="numberDokumen" id="numberDokumen">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tglDokumen" class="col-md-3">No. Dokumen</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="tglDokumen" id="tglDokumen">
                    </div>
                </div>
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
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-success font-weight-bold"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    </div>
                </div>
            </form>
            <script>

            </script>
        @else
            <div id="transaksiReturNonInvoice"></div>
        @endif
    </div>
</div>