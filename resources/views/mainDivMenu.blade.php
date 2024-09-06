<?php
    if($cekUserGroup >= '1'){
        $menuOpen = "";
    }
    else{
        $menuOpen = "menu-open";
    }
?>
@if($cekUserGroup >= '1')
    @foreach($mainMenu as $mm)
        @if($mm->type_menu == '1')
        <li class="nav-item {{$menuOpen}}">
            <a href="#" class="nav-link">
                <i class="{{$mm->icon}} text-purple"></i>
                <p>
                    {{$mm->system_name}}
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @foreach($subMenu as $sm)
                    @if($sm->core_system_id == $mm->idm_system)
                        <li class="nav-item">
                            <a href="{{route($sm->data_menu)}}" class="nav-link">
                                <i class="fa-regular fa-folder-open text-success"></i>
                                <p class="text-navy">
                                    {{$sm->name_menu}}
                                </p>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
        @else
        <li class="nav-item">
            <a href="{{route($mm->link_url)}}" class="nav-link bg-purple bg-gradient" target="_blank">
                <i class="{{$mm->icon}}"></i>
                <p>
                    {{$mm->system_name}}
                </p>
            </a>
        </li>
        @endif
    @endforeach
@else
    @foreach($subMenu as $sm)
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

