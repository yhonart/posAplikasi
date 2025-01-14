<select class="form-control form-control-sm " name="satuan" id="satuan">
    @foreach($satuanItem as $itemSatuan)
        <option value="{{$itemSatuan->size}}">{{$itemSatuan->satuan}}</option>
    @endforeach
</select>