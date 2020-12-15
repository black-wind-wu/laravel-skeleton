@extends('layouts.app')

@section('title', __('Mobile Register'))

@section('content')
    <div class="login-box">
        <div class="container">
            <div class="row mx-0 justify-content-md-center">
                <div class="col-12 col-lg-9 text-center bg-white login_inside_box">
                    <h4 class="mt-0 mb-3 pb-0 pb-lg-4 pt-0 pt-lg-4 title">
                        <span>{{ __('Mobile Register') }}</span>
                    </h4>
                    <div class="login-form">
                        <form id="register_form" class="form" method="POST" action="{{ route('mobile.register.store') }}">
                            @csrf
                            <div class="form-group input-group mb-4">
                                <input id="mobile" type="number" class="form-control form-control-lg @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" placeholder="{{ __('Mobile') }}" required autocomplete="mobile" autofocus>
                                @error('mobile')
                                <span class="invalid-feedback text-left" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group input-group mb-4">
                                <input type="text" class="form-control form-control-lg @error('verify_code') is-invalid @enderror" name="verify_code" placeholder="{{ __('VerifyCode') }}">
                                <div class="input-group-append">
                                    <send-mobile-verify-code mobile="mobile"></send-mobile-verify-code>
                                </div>
                                @error('verify_code')
                                <span class="invalid-feedback text-left" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group input-group mb-4">
                                <input id="password" type="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                                       placeholder="{{ __('Password') }}" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback text-left" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="terms" value="1">
                                <button type="submit" class="btn btn-block text-white btn-lg btn-login">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    @include('auth._social')

                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="btn btn-block register_btn btn-lg text-muted bg-white">
                            {{ __('Already have an account?') }}
                        </a>
                    </div>

                    <div class="mt-4 text-center text-muted">
                        注册即表示你同意网站的
                        <a class="text-primary" href="{{ url('terms') }}" target="_blank">{{ __('Terms') }}</a> 和 <a
                            class="text-primary" href="{{ url('privacy') }}" target="_blank">{{ __('Privacy') }}</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
