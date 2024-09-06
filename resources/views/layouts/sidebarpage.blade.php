<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Enterprise Asset Management</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/style.css')}}">    
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/sweetalert2/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/alertify/css/alertify.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/alertify/css/themes/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Scripts -->
    <script src="{{asset('public/dazbuild/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="{{asset('public/dazbuild/dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('public/js/globalcustome.js')}}"></script>
    <script src="{{asset('public/js/jquery-mask.js')}}"></script>
    <script src="{{asset('public/js/accounting.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/alertify/alertify.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('public/dazbuild/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="{{asset('public/dazbuild/plugins/highcharts/code/highcharts.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/highcharts/code/highcharts-more.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/highcharts/code/modules/exporting.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/highcharts/code/modules/export-data.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/highcharts/code/modules/accessibility.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    
    <script src="{{asset('public/dazbuild/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <style>
        [class^='select2'] {
          border-radius: 0px !important;
          font-size: 15px;
        }
        
        button:hover {  
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);  /* Enhanced shadow on hover */
        } 
        
        input:focus {  
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Customize your box shadow */  
            border-color: #0078d7; /* Change border color on focus */  
        } 
    </style>
</head>
<script>
        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        
        // setTimeout(function () {
        //     if (window.___browserSync___ === undefined && Number(localStorage.getItem('AdminLTE:Demo:MessageShowed')) < Date.now()) {
        //       localStorage.setItem('AdminLTE:Demo:MessageShowed', (Date.now()) + (15 * 60 * 1000))
        //       // eslint-disable-next-line no-alert
        //       alert('Sedang dilakukan update data master stock barang dan harga ')
        //     }
        //  }, 1000)
</script>
<body class="hold-transition sidebar-mini text-sm layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img src="{{asset('public/images/loadPage.gif')}}" alt="AdminLTELogo" height="60" width="60">
          </div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light border-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{url('/')}}" class="nav-link"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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
        
        <aside class="main-sidebar sidebar-light-purple elevation-2">
            <!-- Brand Logo -->
            <a href="{{route('home')}}" class="brand-link"> 
            <img src="{{asset('public/images/favicon_dazira/favicon-32x32.png')}}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">     
                <span class="brand-text font-weight-bold">Toko Ling Ling</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                      <img src="{{asset('public/images/profile.png')}}" alt="User Image">
                    </div>
                    <div class="info">
                      <a href="#" class="d-block">{{Auth::user()->name}}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                      <div id="divSidebar"></div>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            @yield('content')
            <div class="modal MODAL-GLOBAL" id="modal-global-large" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                  <div class="modal-content MODAL-CONTENT-GLOBAL">
                      <!-- Content will be placed here -->
                      <!-- class default MODAL-BODY-GLOBAL -->
                  </div>
              </div>
            </div>
        </div>
        <script>                        
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                const el_modal_all = $('.MODAL-GLOBAL'),
                    el_modal_large = $('#modal-global-large'),
                    id_modal_content = '.MODAL-CONTENT-GLOBAL';
                $(document).on('click','.BTN-OPEN-MODAL-GLOBAL-LG', function(e){
                    e.preventDefault();
                    el_modal_large.modal('show').find(id_modal_content).load($(this).attr('href'));
                });
                el_modal_all.on('show.bs.modal', function () {
                    global_style.container_spinner($(this).find(id_modal_content));
                });
                el_modal_all.on('hidden.bs.modal', function () {
                    $(this).find(id_modal_content).html('');
                });
                
                $.ajax({
                    type : 'get',
                    url : "{{route('home')}}/mainMenu",
                    success : function(response){                
                        $("#divSidebar").html(response);
                    }
                });
            })
        </script>
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Dazira Integrated System
            </div>
            <!-- Default to the left -->
            <strong>&copy; <a href="https://dazira.id">Dazira.id</a>.</strong>
        </footer>
    </div>
</body>
</html>
