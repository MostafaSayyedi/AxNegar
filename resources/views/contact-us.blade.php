@extends('front.layout')
@section('pageTitle', 'صفحه ارتباط با ما')
@section('body')
    <div class="container" style="margin-top: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('ثبت نام') }}</div>
                    <div class="card-body">
                <form class="form-horizontal" action="{{route('contactus.store')}}" method="post">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('نام') }}</label>

                        <div class="col-md-8">
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror" name="name"
                                   value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="subject" class="col-md-2 col-form-label text-md-right">{{ __('موضوع') }}</label>

                        <div class="col-md-8">
                            <input id="subject" type="text"
                                   class="form-control @error('subject') is-invalid @enderror" name="subject"
                                   value="{{ old('subject') }}" required autocomplete="subject" autofocus>

                            @error('subject')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('ایمیل') }}</label>

                        <div class="col-md-8">
                            <input id="email" type="text"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="message" class="col-md-2 col-form-label text-md-right">{{ __('پیام') }}</label>
                        <div class="col-md-8">
                            <textarea  class="form-control @error('message') is-invalid @enderror" autofocus required rows="5" id="message" name="message">{{ old('message') }}</textarea>
                            @error('message')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5">
                        <button type="submit" class="btn btn-primary">
                            {{ __('ثبت') }}
                        </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
