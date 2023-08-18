@extends('layouts.app')

@section('content')
<div class="login-box">
    <div class="card card-outline card-danger">
        <div class="card-header text-center">
          {{-- <a href="../../index2.html" class="h1"><b>CGC</b></a> --}}
          <img style="width: 14em" src="">
        </div>
        <div class="card-body">
            <p class="login-box-msg text-bold">USER LOGIN</p>
            <form method="POST" action="{{ route('login') }}">
                    @csrf
                <div class="input-group mb-3">
                  {{-- <input type="text" class="form-control" placeholder="Email"> --}}
                  <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="User Login">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      {{-- <input type="checkbox" id="remember"> --}}
                      <label for="remember">
                        &nbsp;
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                  </div>
                  <!-- /.col -->
                </div>
            </form>  
        </div>
    </div>
    <div style="position: absolute; left: 5px; bottom: 10px; color: #6c757d;">
      
    </div>
</div>
@endsection
