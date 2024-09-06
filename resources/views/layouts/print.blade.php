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
    <link rel="stylesheet" href="{{asset('public/dazbuild/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{asset('public/dazbuild/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('public/js/globalcustome.js')}}"></script>
    <script src="{{asset('public/js/jquery-mask.js')}}"></script>
    <script src="{{asset('public/js/accounting.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/toastr/toastr.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <!-- InputMask -->
    <script src="{{asset('public/dazbuild/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('public/dazbuild/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    
    
</head>
<body class="hold-transition layout-top-nav layout-fixed text-sm">
    <div class="wrapper">
        @yield('content')
        <div class="modal MODAL-GLOBAL" id="modal-global-large" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
              <div class="modal-content MODAL-CONTENT-GLOBAL">
                  <!-- Content will be placed here -->
                  <!-- class default MODAL-BODY-GLOBAL -->
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
            });            
        </script>
    </div>
</body>
</html>
