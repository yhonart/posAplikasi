<select name="satuan" id="satuan" class="form-control form-control-border border-width-3 satuan prd-input">
    @foreach($satuan as $s)
        <option value="{{$s->product_size}}">{{$s->product_satuan}}</option>
    @endforeach
</select>