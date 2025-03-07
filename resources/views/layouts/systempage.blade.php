<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Enterprise Asset Management</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dazbuild/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
    <!-- Scripts -->
    <script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('public/js/globalcustome.js')}}"></script>
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @yield('content')
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
