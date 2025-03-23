<select class="form-control form-control-sm " name="satuan" id="satuan">
    @foreach($satuanItem as $itemSatuan)
        <option value="{{$itemSatuan->product_size}}">{{$itemSatuan->product_satuan}}</option>
    @endforeach
    @foreach($otherSize as $os)
        <option value="{{$itemSatuan->unit_note}}">{{$itemSatuan->unit_note}}</option>
    @endforeach
</select>