<select class="form-control form-control-sm" name="satuan" id="satuan">
    <option value="0" readonly>--</option>
    @foreach($productSatuan as $satuan)
        <option value="{{$satuan->product_size}}|{{$satuan->product_satuan}}">{{$satuan->product_satuan}}</option>
    @endforeach
</select>