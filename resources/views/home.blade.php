@extends('layouts.sidebarpage')
@section('content')
<nav class="main-header navbar navbar-expand-md navbar-dark navbar-purple border-0">
    <div class="container">
        <a href="../../index3.html" class="navbar-brand">        
            <span class="brand-text font-weight-light"> <strong>Daz</strong>-IS</span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">                    
                    <a href="#" class="nav-link"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a>
                </li>  
                <li class="nav-item">
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
        </div>
    </div>
</nav>
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Welcome <small>{{ Auth::user()->name }}</small></h1>
          </div>          
        </div>
      </div>
    </div>
    <!-- content -->
    <div class="content">
        <div class="container">
            <div id="divViewSystem"></div>            
        </div>
    </div>
</div>

<script>
    $(function(){
        $.ajax({
            type:'GET',
            url:"{{route('home')}}/getMenu",
            success:function(response){
                $("#divViewSystem").html(response);
            }
        })
    })
</script>
@endsection
