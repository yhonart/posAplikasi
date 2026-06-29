@extends('layouts.login')

@section('content')
<!-- <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            🧑‍🔧 MOHON MAAF!,System dalam tahap pemulihan Database, Terima Kasih. 
        </div>
    </div>
</div> -->
<div class="card rounded">
    <div class="card-body text-xs login-card-body text-xs">        
        <img src="{{asset('public/images/logoNiroApps.png')}}" alt="" srcset="" class=" img-fluid">
        <p class="login-box-msg mt-0">POS & Inventory Application</p>
        <hr>
        <form id="fromLogin" method="POST" action="{{ route('login') }}">
            @csrf   
            <div class="input-group mb-3">
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="userName" placeholder="Username" autocomplete="off" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" id="passwordUser" required autocomplete="current-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-key"></span>
                    </div>
                </div>
            </div>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block mb-2">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span>Klik Dibawah Untuk Login Sebagai Admin/Kasir</span>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-12">
                    <button type="button" class="btn btn-outline-info mb-1" id="adminLogin">
                        🧑‍💼Admin
                    </button>
                    <button type="button" class="btn btn-outline-warning mb-1" id="kasirLogin">
                        🧑‍💻Kasir
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    const adminLogin = document.getElementById("adminLogin");
    const kasirLogin = document.getElementById("kasirLogin");
    const userName = document.getElementById("userName");
    const passwordUser = document.getElementById("passwordUser");

    adminLogin.addEventListener("click", () => {
        userName.value = "admin";
        passwordUser.value = "4dmin@2026";
    });
    kasirLogin.addEventListener("click", () => {
        userName.value = "kasir";
        passwordUser.value = "kasir@2026";
    });
</script>
@endsection
