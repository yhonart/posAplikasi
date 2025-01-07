@if(!empty($selectOption))
<select name="subKategori" id="subKategori" class="form-control form-control-sm  select-2">
    @foreach($selectOption as $so)
        <option value="{{$so->idm_sub}}">{{$so->subcat_name}}</option>
    @endforeach
</select>
@else
<select name="subKategori" id="subKategori" class="form-control form-control-sm  select-2">
    <option value="0">{{$selectKategori->cat_name}}</option>
</select>
@endif