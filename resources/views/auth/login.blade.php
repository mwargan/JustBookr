@extends('layouts.auth')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="row">
                <div class="col-md-7 offset-md-3">
                    <img src="/images/bookshelf.svg" width="100%" style="max-height:200px;min-height: 100px;">
                    <h1 class="text-center mb-3">Login to JustBookr</h1>
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="row form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                    <label for="email" class="col-md-3 control-label col-form-label text-md-right">Email</label>

                    <div class="col-md-7">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block invalid-feedback">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                    <label for="password" class="col-md-3 col-form-label text-md-right control-label">Password</label>

                    <div class="col-md-7">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block invalid-feedback">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7 offset-md-3 d-flex">
                        <button type="submit" class="btn btn-primary btn-block">
                            Login
                        </button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                        <a class="float-right small" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                        <a v-if="facebook_app_id" href="/login/facebook" class="btn btn-dark ml-auto" style="background: #3b5998;border-color: #3b5998;">
                Continue with <i class="fab fa-facebook-square fa-fw"></i>
              </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
