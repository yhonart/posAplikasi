<select class="form-control form-control-sm rounded-0" name="subMenu" id="subMenu">
    @foreach($submenu as $sm)
        <option value="{{$sm->idm_submenu}}">{{$sm->name_menu}}</option>
    @endforeach
</select>