@extends('layouts.sidebarpage')

@section('content')
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Profile</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-info">User Profile</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

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
            <div class="col-md-4">
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