@if($countPoint >= '1')
    <div class="form-group row">
        <div class="col-12">
            <label class="label">Nilai Pengembalian Barang Sebelumnya</label>
            <input type="text" name="point" id="point" class="form-control form-control-sm  text-success font-weight-bold" value="{{number_format($disPoint->NumRet,'0',',','.')}}" readonly>
        </div>
    </div>
@endif