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
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username" autocomplete="off" required autofocus>
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
                    <button type="submit" class="btn btn-primary btn-block mb-2">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-info btn-block mb-1" data-toggle="modal" data-target="#exampleModal">
                        User Login Testing
                    </button>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Login Testing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>admin</td>
                                        <td>4dmin@2026</td>
                                        <td>Admin Toko</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
