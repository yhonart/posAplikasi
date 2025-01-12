<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>POS Inventory Management</title>
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
    <script src="{{asset('public/dazbuild/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <style>
        /* [class^='select2'] {
          border-radius: 0px !important;
          font-size: 15px;
        } */        
        button:hover {  
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);  /* Enhanced shadow on hover */
        } 
        
        input:focus {  
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Customize your box shadow */  
            border-color: #0078d7; /* Change border color on focus */  
        } 
        .marquee{padding:0 20px;width:100%;background:#fff;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;-webkit-box-shadow:2px 2px 3px rgba(0,0,0,.05);-o-box-shadow:2px 2px 3px rgba(0,0,0,.05);-ms-box-shadow:2px 2px 3px rgba(0,0,0,.05);box-shadow:2px 2px 3px rgba(0,0,0,.05)}
        #marquee{padding:10px 0;width:100%;overflow:hidden;color: #333;font-size: 14px;font-weight: 500;}    
        .form-control:focus {  
            border-color: #6d28d9; /* changes border color to red */   
            border-width: 3px;            
        }   
        .buttons-print {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #e2e8f0;
        }
        .buttons-excel {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #e2e8f0;
        } 
        .buttons-copy {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #e2e8f0;
        } 
        .buttons-csv {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #e2e8f0;
        } 
        .buttons-pdf {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #e2e8f0;
        } 
        .buttons-colvis {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #e2e8f0;
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
                    <a href="{{route('home')}}" class="nav-link"><i class="fa-solid fa-house"></i> Home</a>
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
        
        <aside class="main-sidebar sidebar-light-purple elevation-1">
            <!-- Brand Logo -->
            <a href="{{route('home')}}" class="brand-link"> 
            <img src="{{asset('public/images/favicon_dazira/favicon-32x32.png')}}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">     
                <span class="brand-text font-weight-bold" id="ajaxClientName"></span>
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
                <div class="form-inline">
                    <div class="input-group">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Cari Menu" id="searchMenu" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                      <div id="divMenuBySearch"></div>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">            
            <div class="row bg-light text-center p-2" id="displayNotif" style="display: none;">
                <div class="col-md-12">
                    <div class="spinner-grow spinner-grow-sm text-warning" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>                   
                    <div class="spinner-grow spinner-grow-sm text-warning" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>                   
                    <div class="spinner-grow spinner-grow-sm text-warning" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>                   
                    <span class="text-sm">PLASE WAIT ...</span>
                </div>
            </div>
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
            $(function(){
                $("#ajaxClientName").load("{{route('home')}}/storeName");
                bsCustomFileInput.init();
            })                      
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
                
                // $.ajax({
                //     type : 'get',
                //     url : "{{route('home')}}/mainMenu",
                //     success : function(response){                
                //         $("#divSidebar").html(response);
                //     }
                // });
                let keyWord = "0";
                funcSearchMenu(keyWord);
                let timer_cari_equipment = null;
                $("#searchMenu").keyup(function (e){
                    e.preventDefault();
                    clearTimeout(timer_cari_equipment);            
                    timer_cari_equipment = setTimeout(function(){
                        let keyWord = $("#searchMenu").val().trim();
                        if (keyWord === '') {
                            keyWord = "0";
                        }
                    funcSearchMenu(keyWord)},500)
                });
                
                function funcSearchMenu(keyWord){                                        
                    $.ajax({
                        type : 'get',
                        url : "{{route('home')}}/searchingMenu/"+keyWord,
                        success : function(response){
                            $("#divMenuBySearch").html(response);
                        }
                    });
                }
            })

            !function(e){e.fn.marquee=function(t){return this.each(function(){var i,a,n,r,s,o=e.extend({},e.fn.marquee.defaults,t),u=e(this),d=3,p="animation-play-state",f=!1,l=function(e,t,i){for(var a=["webkit","moz","MS","o",""],n=0;n<a.length;n++)a[n]||(t=t.toLowerCase()),e.addEventListener(a[n]+t,i,!1)},c=function(e){var t,i=[];for(t in e)e.hasOwnProperty(t)&&i.push(t+":"+e[t]);return i.push(),"{"+i.join(",")+"}"},m={pause:function(){f&&o.allowCss3Support?i.css(p,"paused"):e.fn.pause&&i.pause(),u.data("runningStatus","paused"),u.trigger("paused")},resume:function(){f&&o.allowCss3Support?i.css(p,"running"):e.fn.resume&&i.resume(),u.data("runningStatus","resumed"),u.trigger("resumed")},toggle:function(){m["resumed"==u.data("runningStatus")?"pause":"resume"]()},destroy:function(){clearTimeout(u.timer),u.css("visibility","hidden").html(u.find(".js-marquee:first")),setTimeout(function(){u.css("visibility","visible")},0)}};if("string"==typeof t)e.isFunction(m[t])&&(i||(i=u.find(".js-marquee-wrapper")),!0===u.data("css3AnimationIsSupported")&&(f=!0),m[t]());else{var g;e.each(o,function(e){if(g=u.attr("data-"+e),"undefined"!=typeof g){switch(g){case"true":g=!0;break;case"false":g=!1}o[e]=g}}),o.duration=o.speed||o.duration,r="up"==o.direction||"down"==o.direction,o.gap=o.duplicated?o.gap:0,u.wrapInner('<div class="js-marquee"></div>');var h=u.find(".js-marquee").css({"margin-right":o.gap,"float":"left"});if(o.duplicated&&h.clone(!0).appendTo(u),u.wrapInner('<div style="width:100000px" class="js-marquee-wrapper"></div>'),i=u.find(".js-marquee-wrapper"),r){var v=u.height();i.removeAttr("style"),u.height(v),u.find(".js-marquee").css({"float":"none","margin-bottom":o.gap,"margin-right":0}),o.duplicated&&u.find(".js-marquee:last").css({"margin-bottom":0});var y=u.find(".js-marquee:first").height()+o.gap;o.duration*=(parseInt(y,10)+parseInt(v,10))/parseInt(v,10)}else s=u.find(".js-marquee:first").width()+o.gap,a=u.width(),o.duration*=(parseInt(s,10)+parseInt(a,10))/parseInt(a,10);if(o.duplicated&&(o.duration/=2),o.allowCss3Support){var h=document.body||document.createElement("div"),w="marqueeAnimation-"+Math.floor(1e7*Math.random()),S=["Webkit","Moz","O","ms","Khtml"],x="animation",b="",q="";if(h.style.animation&&(q="@keyframes "+w+" ",f=!0),!1===f)for(var j=0;j<S.length;j++)if(void 0!==h.style[S[j]+"AnimationName"]){h="-"+S[j].toLowerCase()+"-",x=h+x,p=h+p,q="@"+h+"keyframes "+w+" ",f=!0;break}f&&(b=w+" "+o.duration/1e3+"s "+o.delayBeforeStart/1e3+"s infinite "+o.css3easing,u.data("css3AnimationIsSupported",!0))}var I=function(){i.css("margin-top","up"==o.direction?v+"px":"-"+y+"px")},C=function(){i.css("margin-left","left"==o.direction?a+"px":"-"+s+"px")};o.duplicated?(r?i.css("margin-top","up"==o.direction?v:"-"+(2*y-o.gap)+"px"):i.css("margin-left","left"==o.direction?a+"px":"-"+(2*s-o.gap)+"px"),d=1):r?I():C();var A=function(){if(o.duplicated&&(1===d?(o._originalDuration=o.duration,o.duration=r?"up"==o.direction?o.duration+v/(y/o.duration):2*o.duration:"left"==o.direction?o.duration+a/(s/o.duration):2*o.duration,b&&(b=w+" "+o.duration/1e3+"s "+o.delayBeforeStart/1e3+"s "+o.css3easing),d++):2===d&&(o.duration=o._originalDuration,b&&(w+="0",q=e.trim(q)+"0 ",b=w+" "+o.duration/1e3+"s 0s infinite "+o.css3easing),d++)),r?o.duplicated?(d>2&&i.css("margin-top","up"==o.direction?0:"-"+y+"px"),n={"margin-top":"up"==o.direction?"-"+y+"px":0}):(I(),n={"margin-top":"up"==o.direction?"-"+i.height()+"px":v+"px"}):o.duplicated?(d>2&&i.css("margin-left","left"==o.direction?0:"-"+s+"px"),n={"margin-left":"left"==o.direction?"-"+s+"px":0}):(C(),n={"margin-left":"left"==o.direction?"-"+s+"px":a+"px"}),u.trigger("beforeStarting"),f){i.css(x,b);var t=q+" { 100%  "+c(n)+"}",p=e("style");0!==p.length?p.filter(":last").append(t):e("head").append("<style>"+t+"</style>"),l(i[0],"AnimationIteration",function(){u.trigger("finished")}),l(i[0],"AnimationEnd",function(){A(),u.trigger("finished")})}else i.animate(n,o.duration,o.easing,function(){u.trigger("finished"),o.pauseOnCycle?u.timer=setTimeout(A,o.delayBeforeStart):A()});u.data("runningStatus","resumed")};u.bind("pause",m.pause),u.bind("resume",m.resume),o.pauseOnHover&&u.bind("mouseenter mouseleave",m.toggle),f&&o.allowCss3Support?A():u.timer=setTimeout(A,o.delayBeforeStart)}})},e.fn.marquee.defaults={allowCss3Support:!0,css3easing:"linear",easing:"linear",delayBeforeStart:1e3,direction:"left",duplicated:!1,duration:5e3,gap:20,pauseOnCycle:!1,pauseOnHover:!1}}(jQuery);
            $("#marquee").marquee({duration:1e4,gap:50,delayBeforeStart:0,direction:"Right",duplicated:!0,pauseOnHover:!0});
        </script>
        <script type="text/javascript">
        //override defaults
        alertify.defaults.transition = "slide";
        alertify.defaults.theme.ok = "btn btn-primary";
        alertify.defaults.theme.cancel = "btn btn-danger";
        alertify.defaults.theme.input = "form-control";
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
