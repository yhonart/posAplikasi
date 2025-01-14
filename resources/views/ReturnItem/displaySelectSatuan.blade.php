<select class="form-control form-control-sm " name="satuan" id="satuan">
    @foreach($itemOrder as $itemSatuan)
        <option value="{{$itemSatuan->size}}">{{$itemSatuan->satuan}}</option>
    @endforeach
</select>