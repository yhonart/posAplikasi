@if(!empty($selectNopol))
    <input type="text" name="nopol" id="nopol" class="form-control form-control-sm" value="{{$selectNopol->no_utility}}">
@else
    <input type="text" name="nopol" id="nopol" class="form-control form-control-sm" value="0">
@endif