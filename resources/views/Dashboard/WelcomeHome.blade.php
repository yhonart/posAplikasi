@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">    
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item text-info" aria-current="page">
                        Admin
                    </li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <?php
            $arrayHakAkses = array(
                0=>"Tidak Ada Akses",
                1=>"Super Admin",
                2=>"Admin",
                3=>"Sales"
            );
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-primary card-outline">
                        <h3 class="text-title">Welcome Back</h3>
                    </div>
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{asset('public/images/profile.png')}}"
                                alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{$dbUser->name}}</h3>
                        <p class="text-muted text-center">{{$arrayHakAkses[$dbUser->role_code]}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection