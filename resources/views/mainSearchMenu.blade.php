<hr>
@if($cekUserGroup >= 1)
    @foreach($searchSubMenu as $sm)
    <li class="nav-item">
        <a href="{{route($sm->data_menu)}}" class="nav-link">
            <i class="fa-regular fa-folder-open text-success"></i>
            <p class="text-info font-weight-bold">
                {{$sm->name_menu}}
            </p>
        </a>
    </li>
    @endforeach
@endif

