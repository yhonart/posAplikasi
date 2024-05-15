<select name="satuan" id="satuan" class="form-control form-control-sm satuan">
    <option value="0"></option>
    @foreach($satuan as $s)
        <option value="{{$s->product_satuan}}">{{$s->product_satuan}}</option>
    @endforeach
</select>