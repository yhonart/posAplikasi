<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Enterprise Asset Management</title>
    <!-- Default -->
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
<body class="layout-top-nav control-sidebar-slide-open layout-navbar-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light">
            <div class="container">
                <a href="{{url('/')}}" class="navbar-brand">
                    <!--<img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
                    <span class="brand-text font-weight-bold"><i class="fa-solid fa-store"></i> Online Store</span>
                </a>
                
                <!--<ul class="navbar-nav">-->
                <!--    <li class="nav-item">-->
                <!--        <a href="index3.html" class="nav-link"></a>-->
                <!--    </li>-->
                <!--</ul>-->
                
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="button">
                          <i class="fa-solid fa-user"></i> | {{Auth::user()->name}}
                        </a>
                     </li>
                </ul>
            </div>
        </nav>
        
        <div class="content-wrapper">
            @yield('content')
        </div>
        
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
