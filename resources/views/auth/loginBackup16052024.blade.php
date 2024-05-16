@extends('layouts.login')

@section('content')
<div class="card rounded">
    <div class="card-body login-card-body">
        <img src="{{asset('public/images/Logo1.png')}}" alt="" srcset="" class=" img-fluid">
        <p class="login-box-msg mt-0">Integrated System</p>
        <hr>
        <form id="fromLogin" method="POST" action="{{ route('login') }}">
            @csrf   
            <div class="input-group mb-3">
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
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
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
