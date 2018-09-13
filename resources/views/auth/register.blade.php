@extends('layouts.auth')

@section('content')
<div class="container-fluid mt-4 full-height">
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div :title="$t('register')">
                <div class="row">
                    <div class="col-md-7 offset-md-3">
                        <img src="/images/school.png" width="100%" style="max-height:200px;object-fit: scale-down;min-height: 100px;">
                        <h1 class="text-center mb-3">Start trading textbooks</h1>
                    </div>
                </div>
                <div class="row" v-if="facebook_app_id">
                    <div class="col-md-7 offset-md-3 text-center">
                        <a href="/login/facebook" class="btn btn-block btn-dark ml-auto" style="background: #3b5998;border-color: #3b5998;">
                Continue with <i class="fab fa-facebook-square fa-fw"></i>
              </a>
                        <hr class="mt-4 mb-3" />
                    </div>
                </div>
                <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="row form-group{{ $errors->has('name') ? ' is-invalid' : '' }} {{ $errors->has('surname') ? ' has-error' : '' }}">
                            <label for="full_name" class="col-md-3 control-label col-form-label text-md-right">Full name</label>

                            <div class="col-md-7">
                                <input id="full_name" type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                @if ($errors->has('surname'))
                                    <span class="help-block invalid-feedback">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                            <label for="email" class="col-md-3 control-label col-form-label text-md-right">Email</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                            <label for="password" class="col-md-3 control-label col-form-label text-md-right">Password</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-7 offset-md-3 d-flex">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Sign up
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-7 offset-md-3 d-flex">
                                <p>By signing-up you accept the JustBookr <a href="/terms-and-conditions">terms and conditions</a>.</p>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
