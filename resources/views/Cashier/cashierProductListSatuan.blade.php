<select name="satuan" id="satuan" class="form-control form-control-border border-width-3 satuan prd-input">
    <option value="0"></option>
    @foreach($satuan as $s)
        @if($s->stock >= '1')
        <option value="{{$s->product_size}}">{{$s->product_satuan}}</option>
        @endif
    @endforeach
</select>