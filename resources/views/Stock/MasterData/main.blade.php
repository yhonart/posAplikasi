@extends('layouts.sidebarpage')

@section('content')
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-0">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('home')}}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    </div>
                </form>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                    <img src="{{asset('public/images/user.png')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">Call me whenever you can...</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                    </div>
                    <!-- Message End -->
                </a>
            </div>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-light-indigo elevation-2">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link"> 
    <img src="{{asset('public/images/favicon_dazira/favicon-32x32.png')}}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">     
      <span class="brand-text font-weight-bold">Dazira-POS</span>
    </a>

    <div class=" sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fa-solid fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($mastermenu as $sm)
                        <li class="nav-item">
                            <a href="#" class="nav-link ITEM-MAIN-MENU" data-menu="{{$sm->data_menu}}">
                                <i class="fa-solid fa-database"></i>
                                <p>
                                    {{$sm->name_menu}}
                                </p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fa-solid fa-right-left "></i>
                        <p>
                            Transaksi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($transactionmenu as $tm)
                        <li class="nav-item">
                            <a href="#" class="nav-link ITEM-MAIN-MENU" data-menu="{{$tm->data_menu}}">
                            <i class="{{$tm->icon}}"></i>
                                <p>
                                    {{$tm->name_menu}}
                                </p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fa-solid fa-right-left "></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                       @foreach($dashboardMenu as $ds)
                        <li class="nav-item">
                            <a href="#" class="nav-link ITEM-MAIN-MENU" data-menu="{{$ds->data_menu}}">
                            <i class="fa-solid fa-store"></i>
                                <p>
                                    {{$ds->name_menu}}
                                </p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<div class="content-wrapper">    
    <div id="DivContent"></div>    
</div>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });  

        let link = "Dashboard";
        loadPageInfo(link);

        $('.ITEM-MAIN-MENU').on('click', function (e) {
            e.preventDefault();
            let link = $(this).attr('data-menu');
            loadPageInfo(link);
        });
        // Initial 
        $('#tab-menu-home').trigger('foclick');

        function loadPageInfo(link){
            $.ajax({
                type : 'get',
                url : link,
                success : function(response){                
                    $("#DivContent").html(response);
                }
            });
        }
    })
</script>
@endsection