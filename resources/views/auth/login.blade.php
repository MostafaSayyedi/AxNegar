@extends('front.layout')
@section('pageTitle', 'صفحه ورود')
@section('body')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ورود</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('ایمیل') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('رمز عبور') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('مر به خاطر بسپار') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('ورود') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <div>
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('پسورد را فراموش کرده اید؟') }}
                                        </a>
                                    </div>
                                @endif


                            </div>
                        </div>
                        <hr>

                        <h6>
                            <p style="text-align: center">
                                می‌توانید از سرویس گوگل برای ثبت‌نام استفاده کنید
                            </p>
                        </h6>
                        <div class="form-group row mb-0" style="text-align: center">
                            <div class="col-md-8 offset-md-2">
                                <a href="{{ url('/auth/redirect/google') }}" class="btn btn-primary"><i
                                        class="fa fa-google"></i> Google</a>
                                {{--                        <a href="{{ url('/auth/redirect/github') }}" class="btn btn-primary"><i class="fa fa-github"></i> Github</a>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
